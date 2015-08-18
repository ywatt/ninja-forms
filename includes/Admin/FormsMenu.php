<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_FormsMenu extends NF_Admin_Menu
{
    public $page_title = 'Forms';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        echo 'Hello, world!';
    }

}
