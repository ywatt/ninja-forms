<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_EditAction extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';    

    public $page_title = 'Edit Action';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        Ninja_Forms::template( 'admin-menu-edit-action' );
        wp_enqueue_style( 'nf-builder', Ninja_Forms::$url . 'assets/css/builder.css' );
    }

}
