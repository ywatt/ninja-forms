<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_AddField extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';    

    public $page_title = 'Add Field';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        Ninja_Forms::template( 'admin-menu-add-field' );
        wp_enqueue_style( 'nf-builder', Ninja_Forms::$url . 'assets/css/builder.css' );
    }

}
