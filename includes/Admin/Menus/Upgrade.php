<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Upgrade extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Upgrade';

    public $menu_slug = 'nf_upgrade';

    public $priority = 14;

    public function __construct()
    {
        if( ! $this->get_count() ) return;
        
        parent::__construct();

        add_action( 'admin_notices', array( $this, 'admin_notice' ) );
    }

    public function display()
    {
        global $wpdb;
        $forms = $wpdb->get_results( "SELECT id, title FROM " . $wpdb->prefix . 'nf3_forms' );

        wp_enqueue_style( 'nf-admin-menu-upgrade-css', Ninja_Forms::$url . 'assets/css/admin-menu-upgrade.css' );

        wp_enqueue_script( 'nf-backbone-marionette', Ninja_Forms::$url . 'assets/js/lib/backbone.marionette.min.js', array( 'jquery', 'underscore', 'backbone' ) );
        wp_enqueue_script( 'nf-admin-menu-upgrade-js', Ninja_Forms::$url . 'assets/js/admin-menu-upgrade.js', array( 'nf-backbone-marionette' ) );

        wp_localize_script( 'nf-admin-menu-upgrade-js', 'nf_forms', $forms );
        wp_localize_script( 'nf-admin-menu-upgrade-js', 'nf_redirect', admin_url( 'admin.php?page=ninja-forms&nf-upgrade=1' ) );

        Ninja_Forms::template( 'admin-menu-upgrade.html.php' );
    }

    public function get_count(){
        $upgrades = apply_filters( 'ninja_forms_upgrades', array() );
        return count( $upgrades );
    }

    public function admin_notice(){

        if( ! isset( $_GET[ 'page' ] ) || 'ninja-forms' != $_GET[ 'page' ] ) return;
        if( ! isset( $_GET[ 'nf-upgrade' ] ) || ! $_GET[ 'nf-upgrade' ] ) return;

        WPN_Helper::admin_notice(
            'notice notice-info',
            __( 'Upgraded successfully.', 'ninja-forms' )
        );
    }

} // End Class NF_Admin_SystemStatus
