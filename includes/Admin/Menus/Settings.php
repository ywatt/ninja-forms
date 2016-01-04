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
        $grouped_settings[ 'general' ]   = Ninja_Forms()->config( 'PluginSettingsGeneral' );
        $grouped_settings[ 'advanced' ]  = Ninja_Forms()->config( 'PluginSettingsAdvanced' );
        $grouped_settings[ 'recaptcha' ] = Ninja_Forms()->config( 'PluginSettingsReCaptcha' );

        foreach( $grouped_settings as $group => $settings ){
            foreach( $settings as $key => $setting ){}
            $grouped_settings[ $group ][ $key ][ 'value' ] = '';
        }

        $grouped_settings[ 'general' ][ 'version' ][ 'value' ] = Ninja_Forms::VERSION;

        Ninja_Forms::template( 'admin-menu-settings.html.php', compact( 'grouped_settings' ) );

    }
} // End Class NF_Admin_Settings
