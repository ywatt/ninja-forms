<?php
/**
 * This class handles all the update-related stuff for extensions, including adding a license section to the license tab.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Licenses
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
 */

class NF_Extension_Updater {
	
	/**
	 * Define our class variables
	 */
	public $product_nice_name = '';
	public $product_name = '';
	public $version = '';
	public $file = '';
	public $author = '';
	public $ext_url = '';

	/**
	 * Constructor function
	 *
	 * @since 2.2.47
	 * @return void
	 */

	function __construct( $product_name, $version, $author, $file, $slug = '', $ext_url = '' ) {
		$this->product_nice_name = $product_name;
		if ( $slug == '' ) {
			$this->product_name = strtolower( $product_name );
			$this->product_name = preg_replace( "/[^a-zA-Z]+/", "", $this->product_name );			
		} else {
			$this->product_name = $slug;
		}

		$this->version = $version;
		$this->file = $file;
		$this->author = $author;
		if ( $ext_url == '' )
			$ext_url = 'http://ninjaforms.com/downloads/conditional-logic/';
		$this->ext_url = $ext_url;
		
		add_filter( 'nf_settings_licenses', array( $this, 'add_license_field' ) );
		
		// $this->auto_update();

	} // function constructor

	/**
	 * Function that adds the license entry fields to the license tab.
	 *
	 * @access public
	 * @since 2.2.47
	 * @return void
	 */

	public function add_license_field( $licenses ) {

		$licenses[$this->product_name . '_license'] = array(
			'id' 	=> $this->product_name . '_license',
			'name' 	=> $this->product_nice_name,
			'desc' 	=> '<em>' . __( 'Invalid license. Updates will not appear in your dashboard.', 'ninja-forms' ) . '</em> <a href="' . $this->ext_url . '" target="_blank">' . __( 'Get a license.', 'ninja-forms' ) . '</a>',
			'type' 	=> 'license',
			'file' 	=> $this->file
		);

		return $licenses;	
	}

} // class