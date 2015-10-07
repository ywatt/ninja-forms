<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_SystemStatus extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'System Status';

    public $priority = 12;

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        Ninja_Forms::template( 'admin-menu-system-status' );
    }

} // End Class NF_Admin_SystemStatus
