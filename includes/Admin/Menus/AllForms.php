<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_AllForms extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'All Forms';

    private $table = '';

    public function __construct()
    {
        parent::__construct();

        add_action( 'admin_init', array( $this, 'admin_init' ) );
    }

    public function admin_init()
    {
        $this->table = new NF_Admin_AllFormsTable();
    }

    public function display()
    {
        $this->table->prepare_items();

        Ninja_Forms::template( 'admin-menu-all-forms.html.php', array( 'table' => $this->table ) );
    }

}
