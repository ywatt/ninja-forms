<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_plugin_settings_general', array(

    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    */

    'version' => array(
        'id'    => 'version',
        'type'  => 'desc',
        'label' => __( 'Version', 'ninja-forms' ),
        'desc'  => ''
    ),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    'currency' => array(
        'id'      => 'currency',
        'type'    => 'select',
        'options' => Ninja_Forms::config( 'Currency' ),
        'label'   => __( 'Currency', 'ninja-forms' ),
        'value'   => 'USD'
    ),

));
