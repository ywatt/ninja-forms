<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Addons extends NF_Admin_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Addons';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        Ninja_Forms::template( 'admin-menu-addons' );
    }

} // End Class NF_Admin_Addons
