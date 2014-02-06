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
 * Ninja_Forms 
 *
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

		$this->default_form_settings();
		$this->default_form_groups();

		do_action( 'nf_register_admin_settings' );
	}

	private function default_form_settings() {
		$args = array(
			'scope' => 'form',
			'group' => 'display_settings',
			'settings' => array(
				'append_page' => array(
					'type' => 'dropdown',
					'desc' => '',
					'label' => __( 'Add this form to the bottom of this page:', 'ninja-forms' ),
					'options' => array( array( 'name' => 'test', 'value' => 'test'), array( 'name' => 'test2', 'value' => 'test2' ) ),
					'class' => 'widefat code',
				),
				'logged_in' => array(
					'type' => 'checkbox',
					'label' => __( 'Only show this form to logged-in users?', 'ninja-forms' ),
				),
				'ajax' => array(
					'type' => 'checkbox',
					'label' => __( 'Submit the form without reloading the page? (Via Ajax)', 'ninja-forms' ),
				),
				'show_title' => array(
					'type' => 'checkbox',
					'label' => __( 'Output the form title above form?', 'ninja-forms' ),
				),
			),
		);
		$this->register_settings( $args );
	}

	private function default_form_groups() {
		$args = array(
			'scope' => 'form',
			'id' => 'display_settings',
			'label' => 'Display',
			'class' => '',
			'priority' => 'core',
			'desc' => __( 'These settings affect how forms are displayed on the front-end.', 'ninja-forms' ),
			'display_link' => true,
			'settings' => array(
				'test_setting' => array(
					'type' => 'dropdown',
					'desc' => '',
					'label' => __( 'Add this form to the bottom of this page:', 'ninja-forms' ),
					'options' => array( array( 'name' => 'test', 'value' => 'test'), array( 'name' => 'test2', 'value' => 'test2' ) ),
					'class' => 'widefat code',
				),
			),
		);

		$this->register_settings_group( $args );		

		$args = array(
			'scope' => 'form',
			'id' => 'notifications',
			'label' => 'Notifications',
			'priority' => 'default',
			'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
			'custom' => true,
			'display_link' => true,
			'template' => 
				'<div id="" class="tablenav top">
					<div class="alignleft" style="margin-right:15px">
						<a href="#" class="button-primary">'.__( 'Add New', 'ninja-forms' ).'</a>
					</div>
					<div class="alignleft actions">
						<select id="" class="" name="bulk_action">
							<option value="">'.__( 'Bulk Actions', 'ninja-forms' ).'</option>
							<option value="delete">'.__( 'Activate', 'ninja-forms' ).'</option>
							<option value="delete">'.__( 'Deactivate', 'ninja-forms' ).'</option>
							<option value="delete">'.__( 'Delete', 'ninja-forms' ).'</option>
						</select>
						<input type="submit" name="submit" value="'.__( 'Apply', 'ninja-forms' ).'" class="button-secondary">
					</div>
					<div class="alignleft actions">
						<select id="" name="limit">
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
						'.__( 'Notifications Per Page', 'ninja-forms' ).'
						<input type="submit" name="submit" value="'.__( 'Go', 'ninja-forms' ).'" class="button-secondary">
					</div>
				</div>
				<table class="wp-list-table widefat fixed posts">
					<thead>
						<tr>
							<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
							<th>'.__( 'Name', 'ninja-forms' ).'</th>
							<th>'.__( 'Type', 'ninja-forms' ).'</th>
							<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
						</tr>
					</thead>
					<tbody>
					<% _.each(settings, function(setting){ %>
						<tr>
							<th scope="row" class="check-column">
								<input type="checkbox" id="" name="notification_ids[]" value="" class="ninja-forms-bulk-action">
							</th>

							<td class="post-title page-title column-title">
								<strong>
									<a href="#notification_single" class="media-menu-item" id="notification_single" title="" data-notification-id="<%= setting.get( "id" ) %>" data-object-id="<%= setting.get( "id" ) %>" data-scope="notification" data-group="notification_single"><%= setting.get( "name" ) %></a>
								</strong>
								<div class="row-actions">
									<span class="activate"><a href="">'.__( 'Activate', 'ninja-forms' ).'</a> | </span>
									<span class="trash"><a class="ninja-forms-delete-form" title="'.__( 'Delete this notification', 'ninja-forms' ).'" href="#" id="">'.__( 'Delete', 'ninja-forms' ).'</a> | </span>
									<span class="export"><a href="" title="'.__( 'Export Form', 'ninja-forms' ).'">'.__( 'Export', 'ninja-forms' ).'</a> | </span>
									<span class="duplicate"><a href="" title="'.__( 'Duplicate Form', 'ninja-forms' ).'">'.__( 'Duplicate', 'ninja-forms' ).'</a></span>
								</div>
							</td>
							<td>
								<%= setting.get( "type" ) %>
							</td>
							<td>
								6 January 2014
							</td>
						</tr>
						<% }); %>
					</tbody>
					<tfoot>
						<tr>
							<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
							<th>'.__( 'Name', 'ninja-forms' ).'</th>
							<th>'.__( 'Type', 'ninja-forms' ).'</th>
							<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
						</tr>
					</tfoot>
				</table>',
			'settings' => array(
				'test' => array(
					'type' => 'array',
				),
			),
			//'put_filter' => function( $value, $form_setting, $form_id ) { return $value; }
		);

		$this->register_settings_group( $args );

		$args = array(
			'scope' => 'notification',
			'id' => 'notification_single',
			'label' => 'Notifications',
			'display_link' => false,
			'priority' => 'default',
			'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
			'settings' => array(
				'type' => array(
					'type' => 'dropdown',
					'label' => __( 'Type', 'ninja-forms' ),
					'options' => array(
						array('name' => __( 'Email', 'ninja-forms' ), 'value' => 'email'),
						array('name' => __( 'Success Message', 'ninja-forms' ), 'value' => 'success_message'),
						array('name' => __( 'Pushover', 'ninja-forms' ), 'value' => 'pushover'),
						array('name' => __( 'Text Message', 'ninja-forms' ), 'value' => 'text_message'),
					),
					'class' => '',
					'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
				),
				'name' => array(
					'type' => 'text',
					'label' => __( 'Name', 'ninja-forms' ),
					'class' => 'widefat',
					'desc' => __( 'How would you like to identify this notification?', 'ninja-forms' ),
				),
				'mailto' => array(
					'type' => 'radio',
					'label' => __( 'Send To', 'ninja-forms' ),
					'options' => array(
						array('name' => __( 'Enter Email', 'ninja-forms' ), 'value' => 'manual_email'),
						array('name' => __( 'Select a Field', 'ninja-forms' ), 'value' => 'field_value'),
						array('name' => __( 'Configure Routing', 'ninja-forms' ), 'value' => 'configure_routing'),
					),
					'class' => '',
					'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
				),
			),
		);

		$this->register_settings_group( $args );
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
			'class' => '',
			'default_value' => '',		
			'desc' => '',
			'label' => '',
			'options' => '',				
			'type' => '',
		);

		$settings = $args['settings'];
		foreach ( $settings as $id => $setting ) {
			// Parse incomming $args into an array and merge it with $defaults
			$settings[$id] = wp_parse_args( $setting, $defaults );
		}

		$scope = $args['scope'];
		$group = $args['group'];

		if ( ! is_array( $this->settings[$scope][$group]['settings'] ) )
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
		$scope = $args['scope'];
		unset( $args['scope'] );

		$group = $args['id'];
		unset( $args['id'] );

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

	  public function get_setting_groups( $scope ) {
	  	if ( isset ( $this->settings[$scope] ) ) {
	  		return $this->settings[$scope];
	  	} else {
	  		return false;
	  	}
	  }
}