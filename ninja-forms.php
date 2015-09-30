<?php
/*
Plugin Name: Ninja Forms
Plugin URI: http://ninjaforms.com/
Description: Ninja Forms is a webform builder with unparalleled ease of use and features.
Version: 2.9.27
Author: The WP Ninjas
Author URI: http://ninjaforms.com
Text Domain: ninja-forms
Domain Path: /lang/

Copyright 2015 WP Ninjas.
*/



define( 'LOAD_DEPRECATED', FALSE );

if( defined( 'LOAD_DEPRECATED') AND LOAD_DEPRECATED ) {

    include 'deprecated/ninja-forms.php';

} else {

    /**
     * Class Ninja_Forms
     */
    final class Ninja_Forms
    {

        /**
         * @since 3.0
         */
        const VERSION = '2.9.27';

        /**
         * @since 3.0
         */
        const TEXTDOMAIN = 'ninja-forms';

        /**
         * @var Ninja_Forms
         * @since 2.7
         */
        private static $instance;

        /**
         * Plugin Directory
         *
         * @since 3.0
         * @var string $dir
         */
        public static $dir = '';

        /**
         * Plugin URL
         *
         * @since 3.0
         * @var string $url
         */
        public static $url = '';

        /**
         * Admin Menus
         *
         * @since 3.0
         * @var array
         */
        public $menus = array();

        /**
         * AJAX Controllers
         *
         * @since 3.0
         * @var array
         */
        public $controllers = array();

        /**
         * Form Fields
         *
         * @since 3.0
         * @var array
         */
        public $fields = array();

        /**
         * Model Factory
         *
         * @var object
         */
        public $factory = '';

        /**
         * Main Ninja_Forms Instance
         *
         * Insures that only one instance of Ninja_Forms exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @since 2.7
         * @static
         * @staticvar array $instance
         * @return Ninja_Forms Highlander Instance
         */
        public static function instance()
        {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Ninja_Forms ) ) {
                self::$instance = new Ninja_Forms;

                self::$dir = plugin_dir_path( __FILE__ );

                self::$url = plugin_dir_url( __FILE__ );

                /*
                 * Register our autoloader
                 */
                spl_autoload_register( array( self::$instance, 'autoloader' ) );

                /*
                 * Admin Menus
                 */
                self::$instance->menus[ 'forms' ]           = new NF_Admin_Menus_Forms();
                self::$instance->menus[ 'settings' ]        = new NF_Admin_Menus_Settings();
                self::$instance->menus[ 'add-ons' ]         = new NF_Admin_Menus_Addons();
                self::$instance->menus[ 'system_status']    = new NF_Admin_Menus_SystemStatus();

                /*
                 * Admin menus used for building out the admin UI
                 *
                 * TODO: removed once building is complete
                 */
                self::$instance->menus[ 'add-field']        = new NF_Admin_Menus_AddField();
                self::$instance->menus[ 'edit-field']       = new NF_Admin_Menus_EditField();
                self::$instance->menus[ 'add-action']       = new NF_Admin_Menus_AddAction();
                self::$instance->menus[ 'edit-action']      = new NF_Admin_Menus_EditAction();
                self::$instance->menus[ 'edit-settings']    = new NF_Admin_Menus_EditSettings();
                self::$instance->menus[ 'fields-layout']    = new NF_Admin_Menus_FieldsLayout();

                /*
                 * AJAX Controllers
                 */
                self::$instance->controllers[ 'form' ]       = new NF_AJAX_Controllers_Form();
                self::$instance->controllers[ 'uploads' ]    = new NF_AJAX_Controllers_Uploads();
                self::$instance->controllers[ 'submission' ] = new NF_AJAX_Controllers_Submission();

                /*
                 * Field Class Registration
                 */
                self::$instance->fields = apply_filters( 'ninja_forms_register_fields', self::load_classes( 'Fields' ) );

                /*
                 * Form Action Registration
                 */
                self::$instance->actions = apply_filters( 'ninja_forms_register_actions', self::load_classes( 'Actions' ) );


                /*
                 * Temporary Shortcode for working on the frontend JS display.
                 *
                 * TODO: removed once building is complete
                 */
                require_once( self::$dir . 'includes/Display/Shortcodes/tmp-frontend.php' );

                /*
                 * Temporary Shortcode for working on the frontend JS display.
                 *
                 * TODO: remove once build is complete
                 */
                require_once( self::$dir . 'includes/Display/Shortcodes/tmp-frontendform.php' );

                /*
                 * Temporary Shortcode for working on the Async Upload Controller.
                 *
                 * TODO: remove once build is complete
                 */
                require_once( self::$dir . 'includes/Display/Shortcodes/tmp-file-upload.php' );

                /*
                 * Submission CPT
                 */
                new NF_Admin_CPT_Submission();

            }

            return self::$instance;
        }

        /**
         * Autoloader
         *
         * Autoload Ninja Forms classes
         */
        public function autoloader( $class_name )
        {
            if (false !== strpos($class_name, 'NF_')) {
                $class_name = str_replace('NF_', '', $class_name);
                $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
                $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
                if (file_exists($classes_dir . $class_file)) {
                    require_once $classes_dir . $class_file;
                }
            }
        }

        /*
         * PUBLIC API WRAPPERS
         */

        /**
         * Form Model Factory Wrapper
         *
         * @param $id
         * @return NF_Abstracts_ModelFactory
         */
        public function form( $id = '' )
        {
            global $wpdb;

            return new NF_Abstracts_ModelFactory( $wpdb, $id );
        }

        public function display( $form_id )
        {
            if( ! $form_id ) return;

            NF_Display_Render::localize( $form_id );
        }

        public static function template( $file_name = '', $ext = '.html.php' )
        {
            if( ! $file_name ) return;

            include self::$dir . 'includes/Templates/' . $file_name . $ext;
        }

        public static function config( $file_name )
        {
            return include self::$dir . 'includes/Config/' . $file_name . '.php';
        }

        /*
         * PRIVATE METHODS
         */

        private static function load_classes( $prefix = '' )
        {
            $return = array();

            $subdirectory = str_replace( '_', DIRECTORY_SEPARATOR, str_replace( 'NF_', '', $prefix ) );

            $directory = 'includes/' . $subdirectory;

            foreach (scandir( self::$dir . $directory ) as $path) {

                $path = explode( DIRECTORY_SEPARATOR, str_replace( self::$dir, '', $path ) );
                $filename = str_replace( '.php', '', end( $path ) );

                $class_name = 'NF_' . $prefix . '_' . $filename;

                if( ! class_exists( $class_name ) ) continue;

                $return[ strtolower( $filename ) ] = new $class_name;
            }

            return $return;
        }

    } // End Class Ninja_Forms

    /**
     * The main function responsible for returning The Highlander Ninja_Forms
     * Instance to functions everywhere.
     *
     * Use this function like you would a global variable, except without needing
     * to declare the global.
     *
     * Example: <?php $nf = Ninja_Forms(); ?>
     *
     * @since 2.7
     * @return Ninja_Forms Highlander Instance
     */
    function Ninja_Forms()
    {
        return Ninja_Forms::instance();
    }

    Ninja_Forms();
}
