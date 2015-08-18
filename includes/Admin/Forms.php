<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Forms extends NF_Admin_Menu
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
    }

}
