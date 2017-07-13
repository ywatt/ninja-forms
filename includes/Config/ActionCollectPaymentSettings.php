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
    | Payment Type
    |--------------------------------------------------------------------------
    */

    //building the payment type selector box
    'payment_total_type' =>  array(
        'name' => 'payment_total_type',
        'type' => 'select',
        'label' => __( 'Select Payment Type', 'ninja-forms' ),
        'width' => 'one-third',
        'group' => 'primary',
        'options' => array(
            array( 'label' =>  '--', 'value' => '--' ),
            array( 'label' => __( 'Calculation', 'ninja-forms' ), 'value' => 'calculation' ),
            array( 'label' => __( 'Field', 'ninja-forms' ), 'value' => 'field' ),
            array( 'label' => __( 'Custom', 'ninja-forms' ), 'value' => 'custom' ),
        ),
    ),

    //building the calc selector.
    'payment_total_calc' => array(
        'name' => 'payment_total_calc',
        'type' => 'select',
        'label' => __( 'Select A Calculation Variable', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'deps' => array(
            'payment_total_type' => 'calculation',
        ),
        'options' => array(
            'label' => '--',
            'value' => '',
        )
    ),

    //building the field selector.
    'payment_total_field' => array(
        'name' => 'payment_total_field',
        'type' => 'select',
        'label' => __( 'Select A Field', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'deps' => array(
            'payment_total_type' => 'field',
        ),
        'options' => array(
            'label' => '--',
            'value' => '',
        )
    ),

    //building the field selector.
    'payment_total_custom' => array(
        'name' => 'payment_total_custom',
        'type' => 'textbox',
        'label' => __( 'Custom Payment Amount', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'deps' => array(
            'payment_total_type' => 'custom',
        ),
        'use_merge_tags' => false
    ),
));