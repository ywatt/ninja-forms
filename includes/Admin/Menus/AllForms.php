<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_AllForms extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'All Forms';

    private $table = '';

    public function __construct()
    {
        parent::__construct();


    }



    public function display()
    {

    }

}
