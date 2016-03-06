<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Admin_Menus_Licenses
 */
final class NF_Admin_Menus_Licenses
{
    public function __construct()
    {
        add_filter( 'ninja_forms_plugin_settings',        array( $this, 'plugin_settings'        ), 10, 1 );
        add_filter( 'ninja_forms_plugin_settings_groups', array( $this, 'plugin_settings_groups' ), 10, 1 );
    }

    public function plugin_settings( $settings )
    {
        $settings[ 'licenses' ] = array(); //NF_MailChimp()->config( 'PluginSettings' );
        return $settings;
    }

    public function plugin_settings_groups( $groups )
    {
        $groups = array_merge( $groups, array(
            'licenses' => array(
                'id' => 'licenses',
                'label' => __( 'Licenses', 'ninja-forms' ),
            )
        ) );
        return $groups;
    }

} // End Class NF_Admin_Menus_Licenses