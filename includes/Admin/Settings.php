<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Settings extends NF_Admin_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Form Settings';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        Ninja_Forms::template( 'admin-menu-settings' );
    }

} // End Class NF_Admin_Settings
