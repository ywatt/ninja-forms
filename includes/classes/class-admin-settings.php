<?php
/**
 * Register Admin Settings
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Register
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * This class handles the registration of admin settings within Ninja Forms.
 *
 * These settings include form, field, notification, and plugin settings.
 *
 * @since 3.0
 */
class NF_Register_Admin_Settings {
	
	private $settings;

	/**
	 * Get things going
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */

	public function __construct() {
		if ( ! is_admin() )
			return false;

		add_action( 'admin_init', 'nf_default_form_settings' );
		add_action( 'admin_init', 'nf_notification_settings' );
		do_action( 'nf_register_admin_settings' );
	}

	/**
	 * Register admin settings
	 * 
	 * @access public
	 * @param array $args
	 * @since 3.0
	 * @return void
	 */

	public function register_settings( $args = array() ) {
		$defaults = array(
			'class' 		=> '',
			'default_value' => '',		
			'desc' 			=> '',
			'label' 		=> '',
			'options' 		=> '',				
			'type' 			=> '',
			'depend' 		=> '',
		);

		$settings = $args['settings'];
		foreach ( $settings as $id => $setting ) {
			// Parse incomming $args into an array and merge it with $defaults
			$settings[$id] = wp_parse_args( $setting, $defaults );
		}

		$scope = $args['scope'];
		$group = $args['group'];

		if ( ! isset ( $this->settings[$scope][$group]['settings'] ) or ! is_array( $this->settings[$scope][$group]['settings'] ) )
			$this->settings[$scope][$group]['settings'] = array();

		$this->settings[$scope][$group]['settings'] = array_merge_recursive( $this->settings[$scope][$group]['settings'], $settings );
	}

	/**
	 * Register admin settings group
	 * 
	 * @access public
	 * @param array $args
	 * @since 3.0
	 * @return void
	 */

	public function register_settings_group( $args = array() ) {
		$defaults = array(
			'priority' 			=>	'default',
			'display_link' 		=>	true,
			'custom_backbone' 	=> 	false,
		);

		$scope = $args['scope'];
		unset( $args['scope'] );

		$group = $args['id'];
		unset( $args['id'] );

		$args = wp_parse_args( $args, $defaults );

		if ( ! isset( $this->settings[$scope][$group] ) )
			$this->settings[$scope][$group] = array();

		$this->settings[$scope][$group] = array_merge_recursive( $this->settings[$scope][$group], $args );
	}

	/**
	 * Retrieve an admin setting by scope, group, and setting id
	 * 
	 * @access public
	 * @param string $scope
	 * @param string $group
	 * @param string $setting
	 * @since 3.0
	 * @return array $setting_array
	 */

	 public function get_setting( $scope, $group, $setting ) {
	 	if ( isset ( $this->settings[$scope][$group]['settings'][$setting] ) ) {
	 		return $this->settings[$scope][$group]['settings'][$setting];
	 	} else {
	 		return false;
	 	}
	 }

	 /**
	  * Retrieve all admin settings by scope and group
	  * 
	  * @access public
	  * @param string $scope
	  * @since 3.0
	  * @return array $settings_array
	  */

	  public function get_settings( $scope, $group ) {
	  	if ( isset ( $this->settings[$scope][$group]['settings'] ) ) {
	  		return $this->settings[$scope][$group]['settings'];
	  	} else {
	  		return false;
	  	}
	  }

	  /**
	   * Retrieve all admin settings groups by scope
	   * 
	   * @access public
	   * @param string $scope
	   * @since 3.0
	   * @return array $groups
	   */

	  public function get_settings_groups( $scope ) {
	  	if ( isset ( $this->settings[$scope] ) ) {
	  		return $this->settings[$scope];
	  	} else {
	  		return false;
	  	}
	  }
}