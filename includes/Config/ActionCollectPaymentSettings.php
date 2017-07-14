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
        'label' => __( 'Get Total From', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'options' => array(
            array( 'label' => __( '- Select One', 'ninja-forms' ), 'value' => '' ),
            array( 'label' => __( 'Calculation', 'ninja-forms' ), 'value' => 'calculation' ),
            array( 'label' => __( 'Field', 'ninja-forms' ), 'value' => 'field' ),
            array( 'label' => __( 'Specified Amount', 'ninja-forms' ), 'value' => 'custom' ),
        ),
    ),

    //building the calc selector.
    'payment_total_calc' => array(
        'name' => 'payment_total',
        'total_type'  => 'calc',
        'type' => 'select',
        'label' => __( 'Select Calculation', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'deps' => array(
            'payment_total_type' => 'calculation',
        ),
        'default_options' => array(
            'label' => __( '- Select One', 'ninja-forms' ),
            'value' => '',
        )
    ),

    //building the field selector.
    'payment_total_field' => array(
        'name' => 'payment_total',
        'total_type' => 'field',
        'type' => 'select',
        'label' => __( 'Select Field', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'deps' => array(
            'payment_total_type' => 'field',
        ),
        'default_options' => array(
            'label' => __( '- Select One', 'ninja-forms' ),
            'value' => '',
        )
    ),

    //building the field selector.
    'payment_total_static' => array(
        'name' => 'payment_total',
        'total_type' => 'static',
        'type' => 'textbox',
        'label' => __( 'Enter Amount', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'deps' => array(
            'payment_total_type' => 'custom',
        ),
        'use_merge_tags' => false
    ),
));