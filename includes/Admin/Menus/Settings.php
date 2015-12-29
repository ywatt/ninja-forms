<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Settings extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Settings';

    public $priority = 11;

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        $settings[ 'general' ] = Ninja_Forms()->config( 'PluginSettingsGeneral' );

        Ninja_Forms::template( 'admin-menu-settings.html.php', compact( 'settings' ) );
    }

} // End Class NF_Admin_Settings
