<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_AllForms extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'All Forms';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        $table = new NF_Admin_AllFormsTable();
        $table->prepare_items();

        Ninja_Forms::template( 'admin-menu-all-forms.html.php', compact( 'table' ) );
    }

}
