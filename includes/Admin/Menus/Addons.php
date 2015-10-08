<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Addons extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Addons';

    public $priority = 11;

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        Ninja_Forms::template( 'admin-menu-addons.html.php' );
    }

} // End Class NF_Admin_Addons
