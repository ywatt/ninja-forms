<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Convert_Forms_Reset
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
            'name'  => 'reset-conversion',
            'type'  => '',
            'label' => 'Reset Form Conversion',
            'display_function' => array( $this, 'display_advanced_settings' )
        );

        $advanced_settings[] = $new_advanced_setting;

        return $advanced_settings;
    }

    public function display_advanced_settings() {
        add_thickbox();
        //TODO move this to a view
        ?>
        <a href="#TB_inline?width=400&height=auto&inlineId=nfConversionResetConfirm" class="button-primary thickbox">Reset Form Conversion</a>
        <p class="description">
            If your forms are "missing" after updating to 2.9, this button will attempt to reconvert your old forms to show them in 2.9.  Any forms you have made since updating to 2.9 will be reimported at the end of this process.
        </p>
        <div id="nfConversionResetConfirm" style="display: none;">
            <h2>Reset Form Conversion</h2>
            <h3>You are about to reset the form conversion process for v2.9.</h3>
            <p>
                Clicking continue will re-attempt the form conversion process initially attempted by the version 2.9 update. All current forms will remain in the "All Forms" table.
            </p>
            <p>
                <strong>Note: </strong>There is a chance that some forms will be duplicated during this process, in the case of an incomplete initial conversion.
            </p>
            <a class="button-secondary" href="#" onclick="self.parent.tb_remove();return false">Cancel</a>
            <span style="padding: 10px;"> or </span>
            <a class="button-primary" href="<?php echo site_url('wp-admin/index.php?page=ninja-forms-conversion-reset'); ?>">Continue</a>
        </div>
        <?php
    }

} // End Ninja_Forms_View_Admin Class

// Self-Instantiate
new NF_Convert_Forms_Reset();
