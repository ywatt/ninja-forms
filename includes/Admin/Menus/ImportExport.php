<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_ImportExport extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Import / Export';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {

    }

}
