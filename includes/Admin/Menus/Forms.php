<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Forms extends NF_Abstracts_Menu
{
    public $page_title = 'Forms';

    public $menu_slug = 'ninja-forms';

    public $icon_url = 'dashicons-feedback';

    public function __construct()
    {
        parent::__construct();

        add_action( 'admin_menu', array( $this, 'submenu_separators' ), 9000 );
    }

    public function display()
    {
        if( isset( $_GET[ 'form_id' ] ) && $_GET[ 'form_id' ] ){
            $form = Ninja_Forms()->form( $_GET[ 'form_id' ] )->get();

            echo "<h1>" . $form->get_setting( 'title' ) . "</h1>";

            echo "<h2>Form Settings</h2>";

            echo "<pre>";
            var_dump($form->get_settings());
            echo "</pre>";

            echo "<h2>Field Settings</h2>";

            $fields = Ninja_Forms()->form( $form->get_id() )->get_fields();

            foreach( $fields as $field ){
                echo "<pre>";
                var_dump($field->get_settings());
                echo "</pre>";
            }

            echo "<h2>Action Settings</h2>";

            $actions = Ninja_Forms()->form( $form->get_id() )->get_actions();

            foreach( $actions as $action ){
                echo "<pre>";
                var_dump($action->get_settings());
                echo "</pre>";
            }


            die();
        }

        Ninja_Forms::template( 'admin-menu-forms.html.php' );
        wp_enqueue_style( 'nf-builder', Ninja_Forms::$url . 'assets/css/builder.css' );
    }

    public function submenu_separators()
    {
        add_submenu_page( 'ninja-forms', '', '', 'read', '', '' );
    }

}
