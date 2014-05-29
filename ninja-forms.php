<?php
/*
Plugin Name: Ninja Forms
Plugin URI: http://ninjaforms.com/
Description: Ninja Forms is a webform builder with unparalleled ease of use and features.
Version: 2.6.2
Author: The WP Ninjas
Author URI: http://ninjaforms.com
Text Domain: ninja-forms
Domain Path: /lang/

Copyright 2014 WP Ninjas.


This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;
class Ninja_Forms {

	/**
	 * @var Ninja_Forms
	 * @since 3.0
	 */
	private static $instance;

	/**
	 * @var registered field types
	 * @since 3.0
	 */
	public $registered_field_types;

	/**
	 * Main Ninja_Forms Instance
	 *
	 * Insures that only one instance of Ninja_Forms exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @return The highlander Ninja_Forms
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Ninja_Forms ) ) {
			self::$instance = new Ninja_Forms;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->plugin_settings = self::$instance->get_plugin_settings();
			
			self::$instance->register = new NF_Register();
			// Set our field_types var to ''. We'll instantiate the class for this on the init hook.
			self::$instance->field_types = '';

			register_activation_hook( __FILE__, array( self::$instance, 'activation' ) );

			// Register our default field classes.
			self::$instance->register->field( 'checkbox', 'NF_Field_Checkbox' );
			self::$instance->register->field( 'checkbox_list', 'NF_Field_Checkbox_List' );
			self::$instance->register->field( 'text', 'NF_Field_Text' );
			self::$instance->register->field( 'textarea', 'NF_Field_Textarea' );
			self::$instance->register->field( 'hidden', 'NF_Field_Hidden' );
			self::$instance->register->field( 'date', 'NF_Field_Date' );
			self::$instance->register->field( 'time', 'NF_Field_Time' );
			self::$instance->register->field( 'password', 'NF_Field_Password' );
			self::$instance->register->field( 'submit', 'NF_Field_Submit' );
			self::$instance->register->field( 'dropdown', 'NF_Field_Dropdown' );
			self::$instance->register->field( 'multi-select', 'NF_Field_Multi_Select' );
			self::$instance->register->field( 'radio', 'NF_Field_Radio' );
			self::$instance->register->field( 'rating', 'NF_Field_Rating' );
			self::$instance->register->field( 'email', 'NF_Field_Email' );
			self::$instance->register->field( 'phone', 'NF_Field_Phone' );
			self::$instance->register->field( 'hr', 'NF_Field_Hr' );
			self::$instance->register->field( 'html', 'NF_Field_Html' );
			self::$instance->register->field( 'firstname', 'NF_Field_Firstname' );
			self::$instance->register->field( 'lastname', 'NF_Field_Lastname' );
			self::$instance->register->field( 'address', 'NF_Field_Address' );
			self::$instance->register->field( 'city', 'NF_Field_City' );
			self::$instance->register->field( 'state', 'NF_Field_State' );
			self::$instance->register->field( 'postcode', 'NF_Field_Postcode' );
			self::$instance->register->field( 'country', 'NF_Field_Country' );
			self::$instance->register->field( 'spam', 'NF_Field_Spam' );
			self::$instance->register->field( 'honeypot', 'NF_Field_Honeypot' );
			self::$instance->register->field( 'timed_submit', 'NF_Field_Timed_Submit' );
			self::$instance->register->field( 'number', 'NF_Field_Number' );
			self::$instance->register->field( 'auto_total', 'NF_Field_Auto_Total' );
			self::$instance->register->field( 'custom_eq', 'NF_Field_Custom_Equation' );

			// Run an action hook so that third-party devs can register their own field types.
			do_action( 'nf_register_field_types', self::$instance );
			
			self::$instance->field_types = new NF_Field_Types();
			// The form_var variable won't be interacted with directly.
			// Instead, the form( $form_id ) function will act as a wrapper for it.
			self::$instance->form_var = new NF_Form();
			// The field_var variable won't be interacted with directly.
			// Instead, the field( $field_id ) function will act as a wrapper for it.
			self::$instance->field_var = new NF_Field();

			// Add our processing class.
			self::$instance->processing = new NF_Processing();
			// Add our submission class.
			self::$instance->subs_var = new NF_Subs();

			if ( is_admin() ) {
				self::$instance->admin = new NF_Admin();
				self::$instance->admin_rest = new NF_Admin_Rest_API();				
			}

		}

		return self::$instance;
	}

	/**
	 * Function that acts as a wrapper for our field_var - NF_Field() class.
	 * It sets the field_id and then returns the instance, which is now using the
	 * proper field id
	 * 
	 * @access public
	 * @param int $field_id
	 * @since 3.0
	 * @return object self::$instance->field_var
	 */
	public function field( $field_id = '' ) {
		self::$instance->field_var->set_field( $field_id );
		return self::$instance->field_var;
	}

	/**
	 * Function that acts as a wrapper for our form_var - NF_Form() class.
	 * It sets the form_id and then returns the instance, which is now using the
	 * proper form id
	 * 
	 * @access public
	 * @param int $form_id
	 * @since 3.0
	 * @return object self::$instance->form_var
	 */
	public function form( $form_id = '' ) {
		self::$instance->form_var->set_form( $form_id );
		return self::$instance->form_var;
	}

	/**
	 * Function that acts as a wrapper for our subs_var - NF_Subs() class.
	 * It sets the sub_id and then returns the instance, which is now using the
	 * proper sub id
	 * 
	 * @access public
	 * @param int $form_id
	 * @since 3.0
	 * @return object self::$instance->form_var
	 */
	public function sub( $sub_id = '' ) {
		self::$instance->subs_var->set_sub( $sub_id );
		return self::$instance->subs_var;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ninja-forms' ), '1.6' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ninja-forms' ), '1.6' );
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function setup_constants() {
		global $wpdb;

		// Plugin version
		if ( ! defined( 'NF_VERSION' ) ) {
			define( 'NF_PLUGIN_VERSION', '3.0' );
		}

		// Plugin Folder Path
		if ( ! defined( 'NF_PLUGIN_DIR' ) ) {
			define( 'NF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'NF_PLUGIN_URL' ) ) {
			define( 'NF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'NF_PLUGIN_FILE' ) ) {
			define( 'NF_PLUGIN_FILE', __FILE__ );
		}

		// Plugin Table Names ***********

		// Objects table name
		if ( ! defined( 'NF_OBJECTS_TABLE_NAME') )
			define( 'NF_OBJECTS_TABLE_NAME', $wpdb->prefix . 'nf_objects' );

		// Meta table name
		if ( ! defined( 'NF_META_TABLE_NAME' ) )
			define( 'NF_META_TABLE_NAME', $wpdb->prefix . 'nf_objectmeta' );

		// Relationships table name
		if ( ! defined( 'NF_RELATIONSHIPS_TABLE_NAME' ) )
			define( 'NF_RELATIONSHIPS_TABLE_NAME', $wpdb->prefix . 'nf_relationships' );

		// Legacy Table Names ***********
		
		// Ninja Forms table name
		if ( ! defined( 'NINJA_FORMS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_TABLE_NAME', $wpdb->prefix . 'ninja_forms' );

		// Fields table name
		if ( ! defined( 'NINJA_FORMS_FIELDS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_FIELDS_TABLE_NAME', $wpdb->prefix . 'ninja_forms_fields' );

		// Fav fields table name
		if ( ! defined( 'NINJA_FORMS_FAV_FIELDS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_FAV_FIELDS_TABLE_NAME', $wpdb->prefix . 'ninja_forms_fav_fields' );

		// Subs table name
		if ( ! defined( 'NINJA_FORMS_SUBS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_SUBS_TABLE_NAME', $wpdb->prefix . 'ninja_forms_subs' );
	}

	/**
	 * Include our Class files
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {
		if ( is_admin() ) {
			require_once( NF_PLUGIN_DIR . 'classes/admin.php' );
			require_once( NF_PLUGIN_DIR . 'classes/admin-rest.php' );
			require_once( NF_PLUGIN_DIR . 'classes/all-forms-table.php' );
		}

		require_once( NF_PLUGIN_DIR . 'includes/ajax.php' );
		require_once( NF_PLUGIN_DIR . 'includes/functions.php' );
		require_once( NF_PLUGIN_DIR . 'includes/shortcodes.php' );

		require_once( NF_PLUGIN_DIR . 'classes/register.php' );
		require_once( NF_PLUGIN_DIR . 'classes/field-types.php' );
		require_once( NF_PLUGIN_DIR . 'classes/form.php' );
		require_once( NF_PLUGIN_DIR . 'classes/field.php' );
		require_once( NF_PLUGIN_DIR . 'classes/processing.php' );
		require_once( NF_PLUGIN_DIR . 'classes/subs.php' );

		// include our default field classes
		require_once( NF_PLUGIN_DIR . 'classes/fields/base-field.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/text.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/list.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/textarea.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/checkbox.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/checkbox-list.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/date.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/time.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/password.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/submit.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/dropdown.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/multi-select.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/radio.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/rating.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/email.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/phone.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/hr.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/html.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/firstname.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/lastname.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/address.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/city.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/state.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/postcode.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/country.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/hidden.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/spam.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/honeypot.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/timed-submit.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/number.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/calc.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/auto-total.php' );
		require_once( NF_PLUGIN_DIR . 'classes/fields/custom-eq.php' );
		
	}

	/**
	 * Get our current settings values
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $settings
	 */
	public function get_plugin_settings() {
		return apply_filters( 'nf_get_settings', get_option( 'nf_settings' ) );
	}

	/**
	 * Upon activation, setup our super admin
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function activation() {
		
	}

} // End Class

/**
 * The main function responsible for returning The Highlander Ninja_Forms
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $dwp = Ninja_Forms(); ?>
 *
 * @since 1.0
 * @return object The Highlander Ninja_Forms Instance
 */
function Ninja_Forms() {
	return Ninja_Forms::instance();
}

// Get Ninja_Forms Running
Ninja_Forms();
