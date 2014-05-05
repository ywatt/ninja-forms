<?php
/**
 * Handles license checking for extensions
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Licenses
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_License {

	/**
	 * @var store url
	 */
	public $store_url = 'http://ninjaforms.com';

	/**
	 * 
	 * Get things started
	 *
	 * @since 3.0
	 * @return void
	 */

	function __construct() {
		add_filter( 'nf_settings_sanitize_license', array( $this, 'check_license' ), 10, 2 );
	}

	/**
	 * Function that gets license info from the 'product_license' setting.
	 * 
	 * @access public
	 * @since 3.0
	 * @param string $key The settings key that the license was registered with, i.e. 'extension_license'.
	 * @return array $license;
	 */
	public function get_license_settings( $key ) {
		$registered_settings = Ninja_Forms()->admin->get_registered_settings();

		if ( isset ( $registered_settings['licenses'][$key] ) ) {
			return $registered_settings['licenses'][$key];
		} else {
			return false;
		}
	}

	/**
	 * Function that activates the license for this product
	 *
	 * @access public
	 * @since 2.2.47
	 * @return void
	 */

	public function check_license( $value, $key ) {

		if ( ! $this->get_license_settings( $key ) )
			return $value;

		$plugin_settings = Ninja_Forms()->plugin_settings;

		if( isset( $plugin_settings[ $key . '_status' ] ) ){
			$status = $plugin_settings[ $key . '_status' ];
		}else{
			$status = 'invalid';
		}

		if( isset( $plugin_settings[ $key ] ) ){
			$old_license = $plugin_settings[ $key ];
		}else{
			$old_license = '';
		}

		if ( isset ( $_POST[ $key . '_deactivate' ] ) && ! empty ( $_POST[ $key . '_deactivate' ] ) ) {
			$this->deactivate_license( $key );
			$value = '';
		} else if ( $old_license != '' && $old_license != $value && $status == 'valid' ) {
			$this->deactivate_license( $key );
		} else if( $value != '' && ( $old_license == '' || ( $old_license != $value ) || $status == 'invalid' ) ) {
	 		$this->activate_license( $value, $key );
	 	}

		return $value;
	} // function check_license

	/**
	 * Function that activates our license
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */

	public function activate_license( $license, $settings_key ) {
		$license_settings = $this->get_license_settings( $settings_key );

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( $license_settings['name'] ) // the name of our product in EDD
		);
 
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, $this->store_url ) );
 		
		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;
 		
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "valid" or "invalid"
		// Update our plugin settings
		Ninja_Forms()->plugin_settings[ $settings_key . '_status' ] = $license_data->license;

	}

	/**
	 * Function that deactivates our license if the user clicks the "Deactivate License" button.
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */

	public function deactivate_license( $settings_key ) {
		$license_settings = $this->get_license_settings( $settings_key );
		$license = Ninja_Forms()->plugin_settings[ $settings_key ];

		if( isset( $plugin_settings[ $settings_key . '_status' ] ) ){
			$status = $plugin_settings[ $settings_key . '_status' ];
		}else{
			$status = 'invalid';
		}
		
		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( $license_settings['name'] ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, $this->store_url ), array( 'timeout' => 15, 'sslverify' => false ) );

 		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ) {
			// $license_data->license will be either "valid" or "invalid"
			Ninja_Forms()->plugin_settings[ $settings_key . '_status' ] = 'invalid';
			Ninja_Forms()->plugin_settings[ $settings_key ] = '';
		}
	}

 	/**
	 * Function that gets the current license status.
	 * Returns bool(true) if valid and bool(false) if invalid.
	 *
	 * @since 3.0
	 * @return void
	 */

	public function get_license_status( $settings_key ) {
		$plugin_settings = Ninja_Forms()->plugin_settings;

		if( !isset( $plugin_settings[ $settings_key ] ) || $plugin_settings[ $settings_key ] == 'invalid' ){
			return false;
		}else{
			return true;
		}
	} // function get_license_status

	/**
	 * Function that runs all of our auto-update functionality
	 *
	 * @access public
	 * @since 2.2.47
	 * @return void
	 */

	public function auto_update() {
		$plugin_settings = Ninja_Forms()->plugin_settings;

		// retrieve our license key from the DB
		if( isset( $plugin_settings[ $this->product_name.'_license' ] ) ){
		  $license = $plugin_settings[ $this->product_name.'_license' ];
		}else{
		  $license = '';
		}

		// setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater( $this->store_url, $this->file, array(
		    'version'   => $this->version,     // current version number
		    'license'   => $license,  // license key (used get_option above to retrieve from DB)
		    'item_name'     => $this->product_nice_name,  // name of this plugin
		    'author'  => $this->author,  // author of this plugin
		  )
		);
	} // function auto_update
}