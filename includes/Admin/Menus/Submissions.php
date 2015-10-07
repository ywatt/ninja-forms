<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Submissions extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Submissions';

    public $menu_slug = 'edit.php?post_type=nf_subs';

    public $function = NULL;

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        // This section intentionally left blank.
    }

}
