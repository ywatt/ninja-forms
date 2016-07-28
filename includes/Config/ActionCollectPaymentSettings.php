<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_action_collect_payment_settings', array(

    /*
    |--------------------------------------------------------------------------
    | Payment Gateways
    |--------------------------------------------------------------------------
    */

    'payment_gateways' => array(
        'name' => 'payment_gateways',
        'type' => 'select',
        'label' => __( 'Payment Gateways', 'ninja-forms' ),
        'options' => array(
            array(
                'label' => '--',
                'value' => ''
            ),
        ),
        'value' => '',
        'width' => 'full',
        'group' => 'primary',
    ),

    /*
    |--------------------------------------------------------------------------
    | Payment Total
    |--------------------------------------------------------------------------
    */

    'payment_total' => array(
        'name' => 'payment_total',
        'type' => 'textbox',
        'label' => __( 'Payment Total', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'use_merge_tags' => TRUE
    ),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    'currency' => array(
        'name' => 'currency',
        'type' => 'select',
        'label' => __( 'Currency', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'advanced',
        'options' => Ninja_Forms::config( 'CurrencyList' ),
        'value' => Ninja_Forms()->get_setting( 'currency', 'USD' )
    ),

));
