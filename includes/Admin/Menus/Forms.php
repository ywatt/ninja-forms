<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Forms extends NF_Abstracts_Menu
{
    public $page_title = 'Forms';

    public $menu_slug = 'ninja-forms';

    public $icon_url = 'dashicons-feedback';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        Ninja_Forms::template( 'admin-menu-forms' );
        wp_enqueue_script( 'backbone-marionette', Ninja_Forms::$url . 'assets/js/lib/backbone.marionette.min.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'requirejs', Ninja_Forms::$url . 'assets/js/lib/require.js', array( 'jquery', 'backbone' ) );
        wp_enqueue_script( 'nf-requirejs-main', Ninja_Forms::$url . 'assets/js/builder/main.js', array( 'jquery', 'jquery-ui-core', 'jquery-effects-core', 'jquery-effects-slide', 'requirejs' ) );

        wp_localize_script( 'nf-requirejs-main', 'nfAdmin', array( 'requireBaseUrl' => Ninja_Forms::$url . 'assets/js/' ) );
    }

}
