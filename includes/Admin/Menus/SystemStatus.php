<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_SystemStatus extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'System Status';

    public $priority = 12;

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        /** @global wpdb $wpdb */
        global $wpdb;

        $locale = localeconv();

        if ( is_multisite() ) {
            $multisite = __( 'Yes', 'ninja-forms' );
        } else {
            $multisite =  __( 'No', 'ninja-forms' );
         }

         //TODO: Ask if this check is need
         //if ( function_exists( 'phpversion' ) ) echo esc_html( phpversion() )


         //TODO: Possible refactor
         foreach( $locale as $key => $val ){
             if( is_string( $val) ){
                $data = $key . ': ' . $val . '</br>';
             }
         }

         if ( defined('WP_DEBUG') && WP_DEBUG ){
             $debug = __( 'Yes', 'ninja-forms' );
         } else {
            $debug =  __( 'No', 'ninja-forms' );
         }

         if ( defined( 'WPLANG' ) && WPLANG ) {
            $lang = WPLANG();
         } else {
            $lang = __( 'Default', 'ninja-forms' );
         }

         //TODO: Ask if this long list of ini_get checks are need?

        //  if( function_exists( 'ini_get' ) ){
        //     $get_ini = size_format( ini_get('post_max_size') );
        //  }

        if ( extension_loaded( 'suhosin' ) ) {
            $suhosin =  __( 'Yes', 'ninja-forms' );
        } else {
            $suhosin =  __( 'No', 'ninja-forms' );
        }

        $default_timezone = date_default_timezone_get();
        if ( 'UTC' !== $default_timezone ) {
            echo sprintf( __( 'Default timezone is %s - it should be UTC', 'ninja-forms' ), $default_timezone );
        } else {
            echo sprintf( __( 'Default timezone is %s', 'ninja-forms' ), $default_timezone );
        }
        $environment = array(
            __( 'Home URL','ninja-forms' ) => home_url(),
            __( 'Site URL','ninja-forms' ) => site_url(),
            __( 'Ninja Forms Version','ninja-forms' ) => esc_html( Ninja_Forms::VERSION ),
            __( 'WP Version','ninja-forms' ) => get_bloginfo('version'),
            __( 'WP Multisite Enabled','ninja-forms' ) => $multisite,
            __( 'Web Server Info','ninja-forms' ) => esc_html( $_SERVER['SERVER_SOFTWARE'] ),
            __( 'PHP Version','ninja-forms' ) => esc_html( phpversion() ),
            //TODO: Possibly Refactor with Ninja forms global $_db?
            __( 'MySQL Version','ninja-forms' ) => $wpdb->db_version(),
            __( 'PHP Locale','ninja-forms' ) =>  $data,
            //TODO: Possibly move the ninja_forms_letters_to_numbers function over.
            __( 'WP Memory Limit','ninja-forms' ) => size_format( WP_MEMORY_LIMIT ),
            __( 'WP Debug Mode', 'ninja-forms' ) => $debug,
            __( 'WP Language', 'ninja-forms' ) => $lang,
            __( 'WP Max Upload Size','ninja-forms' ) => size_format( wp_max_upload_size() ),
            __('PHP Post Max Size','ninja-forms' ) => size_format( ini_get('post_max_size') ),
            __('Max Input Nesting Level','ninja-forms' ) => ini_get('max_input_nesting_level'),
            __('PHP Time Limit','ninja-forms' ) => ini_get('max_execution_time'),
            __( 'PHP Max Input Vars','ninja-forms' ) => ini_get('max_input_vars'),
            __( 'SUHOSIN Installed','ninja-forms' ) => $suhosin,
            __( 'SMTP','ninja-forms' ) => ini_get('SMTP'),
            __( 'smtp_port','ninja-forms' ) => ini_get('smtp_port'),
            __( 'Default Timezone','ninja-forms' ) => $default_timezone,
        );



        Ninja_Forms::template( 'admin-menu-system-status.html.php', compact( 'environment' ) );
    }
} // End Class NF_Admin_SystemStatus
