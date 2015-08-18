<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_SystemStatus extends NF_Admin_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'System Status';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        echo 'Hello, settings!';
    }

} // End Class NF_Admin_SystemStatus
