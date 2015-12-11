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
        $mock_data = new NF_Database_MockData();

        $mock_data->form_blank_form();
        $mock_data->form_contact_form_1();
        $mock_data->form_contact_form_2();
        $mock_data->form_product_1();
        $mock_data->form_email_submission();
        $mock_data->form_long_form();
        $mock_data->form_kitchen_sink();

        echo '<div class="wrap">Migrations and Mock Data complete. <a href="' . admin_url( "admin.php?page=ninja-forms" ) . '">View Forms</a></div>';
    }

} // End Class NF_Admin_Settings
