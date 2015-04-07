<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Conversion_Reset
{
    public function __construct()
    {
        add_action('admin_menu', array( $this, 'register_submenu'), 9001);
        add_filter( 'nf_general_settings_advanced', array( $this, 'register_advanced_settings' ) );
    }

    public function register_submenu()
    {
        add_submenu_page(
            NULL,                           // Parent Slug
            'Ninja Forms Conversion Reset', // Page Title
            'Ninja Forms Conversion Reset', // Menu Title
            'manage_options',               // Capability
            'ninja-forms-conversion-reset', // Menu Slug
            array( $this, 'process')        // Function
        );
    }

    public function process()
    {
        global $wpdb;

        // Remove our "converted" flags from the options table
        // delete_option( 'nf_convert_forms_complete' );
        // delete_option( 'nf_converted_forms' );

        // TODO add flag for conversion reset
    }

    public function register_advanced_settings( $advanced_settings ) {

        $new_advanced_setting = array(
            'name'  => 'reset-conversions',
            'type'  => '',
            'label' => 'Reset Conversions',
            'display_function' => array( $this, 'display_advanced_settings' )
        );

        $advanced_settings[] = $new_advanced_setting;

        return $advanced_settings;
    }

    public function display_advanced_settings() {
        echo '<a href="' . site_url('wp-admin/index.php?page=ninja-forms-conversion-reset') . '" class="button-primary">Reset Conversion</a>';
    }

} // End Ninja_Forms_View_Admin Class

// Self-Instantiate
new NF_Conversion_Reset();
