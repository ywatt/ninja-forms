<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_MockData extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Mock Data';

    public $priority = 9002;

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        echo '<div class="wrap">Hello, migrations!</div>';

        $mock_data = new NF_Database_MockData();

        $mock_data->form_contact_form_1();
        $mock_data->form_contact_form_2();
        $mock_data->form_long_form();
    }

} // End Class NF_Admin_Settings
