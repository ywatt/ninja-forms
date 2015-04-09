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
            array( $this, 'display')        // Function
        );
    }

    public function display() {
        echo "<h1>Reset Forms Conversion</h1>";

        $this->process();

        echo '<script>window.location.replace("' . site_url('wp-admin/index.php?page=nf-processing&action=convert_forms&title=Updating+Form+Database') . '");</script>';
    }

    public function process()
    {
        // Remove our "converted" flags from the options table
        delete_option( 'nf_convert_forms_complete' );
        delete_option( 'nf_converted_forms' );

        // Add flag for conversion being reset
        update_option( 'nf_converted_form_reset', '1' );
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
        add_thickbox();
        //TODO move this to a view
        ?>
        <a href="#TB_inline?width=400&height=200&inlineId=nfConversionResetConfirm" class="button-primary thickbox">Reset Conversion</a>
        <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet architecto corporis deleniti dolorum eos id itaque maiores non omnis, perspiciatis, qui quisquam rem ullam. Earum est fugiat illo molestiae tempore.
        </p>
        <div id="nfConversionResetConfirm" style="display: none;">
            <h2>Reset Conversion</h2>
            <p>
                <strong>You are about to reset the conversion process.</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus dolores iusto recusandae repellendus voluptatum! Architecto libero odit voluptas? Consequatur consequuntur cupiditate impedit ipsum porro saepe sit temporibus veritatis voluptatem voluptates?
            </p>
            <a class="button-secondary" href="#" onclick="self.parent.tb_remove();return false">No, nevermind.</a>
            <span style="padding: 10px;"> or </span>
            <a class="button-primary" href="<?php echo site_url('wp-admin/index.php?page=ninja-forms-conversion-reset'); ?>">Yes, continue.</a>
        </div>
        <?php
    }

} // End Ninja_Forms_View_Admin Class

// Self-Instantiate
new NF_Conversion_Reset();
