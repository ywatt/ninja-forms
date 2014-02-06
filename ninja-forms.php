<?php
/*
Plugin Name: Ninja Forms
Plugin URI: http://ninjaforms.com/
Description: Ninja Forms is a webform builder with unparalleled ease of use and features.
Version: 2.2.55
Author: The WP Ninjas
Author URI: http://ninjaforms.com
Text Domain: ninja-forms
Domain Path: /lang/

Copyright 2011 WP Ninjas/Kevin Stover.


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

Ninja Forms also uses the following jQuery plugins. Their licenses can be found in their respective files.

	jQuery TipTip Tooltip v1.3
	code.drewwilson.com/entry/tiptip-jquery-plugin
	www.drewwilson.com
	Copyright 2010 Drew Wilson

	jQuery MaskedInput v.1.3.1
	http://digitalbush.co
	Copyright (c) 2007-2011 Josh Bush

	jQuery Tablesorter Plugin v.2.0.5
	http://tablesorter.com
	Copyright (c) Christian Bach 2012

	jQuery AutoNumeric Plugin v.1.9.15
	http://www.decorplanit.com/plugin/
	By: Bob Knothe And okolov Yura aka funny_falcon

*/



/**
 * Main Ninja Forms class
 * 
 * This class handles the registration/output/saving of Form and Field settings.
 * 
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Ninja_forms' ) ) :

/**
 * Main Ninja_forms Class
 *
 * @since 1.4
 */
final class Ninja_Forms {
	/** Singleton *************************************************************/

	/**
	 * @var Ninja_forms The one true Ninja_forms
	 * @since 1.4
	 */
	private static $instance;

	/**
	 * Main Ninja_forms Instance
	 *
	 * Insures that only one instance of Ninja_forms exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.4
	 * @static
	 * @staticvar array $instance
	 * @uses Ninja_forms::includes() Include the required files
	 * @uses Ninja_forms::setup_constants() Setup Plugin Constants
	 * @see NF()
	 * @return The one true Ninja_forms
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Ninja_forms ) ) {
			self::$instance = new Ninja_Forms;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->load_textdomain();
			self::$instance->set_transient_id();
			self::$instance->admin_settings = new NF_Register_Admin_Settings();
			self::$instance->admin_rest = new NF_Admin_Rest_API();

		}
		return self::$instance;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 3.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ninja-forms' ), '3.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.6
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ninja-forms' ), '3.0' );
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.4
	 * @return void
	 */
	private function setup_constants() {
		global $wpdb;

		// Plugin version
		if ( ! defined( 'EDD_VERSION' ) )
			define( 'NF_VERSION', '3.0' );

		// Objects table name
		if ( ! defined( 'NF_OBJECTS_TABLE_NAME') )
			define( 'NF_OBJECTS_TABLE_NAME', $wpdb->prefix . 'nf_objects' );

		// Meta table name
		if ( ! defined( 'NF_META_TABLE_NAME' ) )
			define( 'NF_META_TABLE_NAME', $wpdb->prefix . 'nf_objectmeta' );

		// Relationships table name
		if ( ! defined( 'NF_RELATIONSHIPS_TABLE_NAME' ) )
			define( 'NF_RELATIONSHIPS_TABLE_NAME', $wpdb->prefix . 'nf_relationships' );

		// Plugin Folder Path
		if ( ! defined( 'NF_PLUGIN_DIR' ) )
			define( 'NF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL
		if ( ! defined( 'NF_PLUGIN_URL' ) )
			define( 'NF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File
		if ( ! defined( 'NF_PLUGIN_FILE' ) )
			define( 'NF_PLUGIN_FILE', __FILE__ );

		// Legacy constants //

		// Plugin version
		if ( ! defined( 'NINJA_FORMS_VERSION' ) )
			define( 'NINJA_FORMS_VERSION', '3.0' );

		// Plugin folder path
		if ( ! defined( 'NINJA_FORMS_DIR' ) )
			define( 'NINJA_FORMS_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin folder url
		if ( ! defined( 'NINJA_FORMS_URL' ) )
			define( 'NINJA_FORMS_URL', plugin_dir_url( __FILE__ ) );

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
	 * Include required files
	 *
	 * @access private
	 * @since 1.4
	 * @return void
	 */
	private function includes() {
		/* Require Core Files */
		// These files are required for both backend and frontend Ninja Forms stuff.
		require_once( NF_PLUGIN_DIR . '/includes/database.php' );
		require_once( NF_PLUGIN_DIR . '/includes/register.php' );
		require_once( NF_PLUGIN_DIR . '/includes/functions.php' );
		require_once( NF_PLUGIN_DIR . '/includes/admin/form-preview.php' );
		

		/* Require Admin Files */
		// These files are required for the backend only
		if ( is_admin() ) {
			require_once( NF_PLUGIN_DIR . '/includes/activation.php' );

			require_once( NF_PLUGIN_DIR . '/includes/admin/admin.php' );
			require_once( NF_PLUGIN_DIR . '/includes/classes/class-rest-api.php' );
			require_once( NF_PLUGIN_DIR . '/includes/admin/all-forms-list.php' );
			require_once( NF_PLUGIN_DIR . '/includes/admin/scripts.php' );
			require_once( NF_PLUGIN_DIR . '/includes/classes/class-admin-settings.php' );
			require_once( NF_PLUGIN_DIR . '/includes/classes/class-admin-pages.php' );

			//Require EDD autoupdate file
			if( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
				// load our custom updater if it doesn't already exist
				require_once(NF_PLUGIN_DIR.'/includes/classes/EDD_SL_Plugin_Updater.php');
			}

			require_once( NF_PLUGIN_DIR . '/includes/classes/class-extension-updater.php' );
		}
	}

	/**
	 * Setup transient ID if it exists
	 * 
	 * @access private
	 * @since 3.0
	 * @return void
	 */

	private function set_transient_id() {
		if(session_id() == '') {
			session_start();
		}
		if ( !isset ( $_SESSION['ninja_forms_transient_id'] ) AND !is_admin() ) {
			$t_id = ninja_forms_random_string();
			// Make sure that our transient ID isn't currently in use.
			while ( get_transient( $t_id ) !== false ) {
				$_id = ninja_forms_random_string();
			}
			$_SESSION['ninja_forms_transient_id'] = $t_id;
		}
	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */

	public function load_textdomain() {

		/** Set our unique textdomain string */
		$textdomain = 'ninja-forms';

		/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
		$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );

		/** Set filter for WordPress languages directory */
		$wp_lang_dir = apply_filters(
			'ninja_forms_wp_lang_dir',
			WP_LANG_DIR . '/ninja-forms/' . $textdomain . '-' . $locale . '.mo'
		);

		/** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
		load_textdomain( $textdomain, $wp_lang_dir );

		/** Translations: Secondly, look in plugin's "lang" folder = default */
		$lang_dir = apply_filters( 'ninja_forms_lang_dir', NF_PLUGIN_DIR . '/lang/' );
		load_plugin_textdomain( $textdomain, FALSE, $lang_dir );
	}

} // End Ninja Forms Class 

endif; // End if class_exists check

/**
 * The main function responsible for returning the one true Ninja_Forms
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $ninja_forms = Ninja_Forms(); ?>
 *
 * @since 1.4
 * @return object The one true Ninja_Forms Instance
 */
function Ninja_Forms() {
	return Ninja_Forms::instance();
}

// Get Ninja_Forms Running
Ninja_Forms();