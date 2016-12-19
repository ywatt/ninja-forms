<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_plugin_settings_groups', array(

    'general' => array(
        'id' => 'general',
        'label' => __( 'General Settings', 'ninja-forms' ),
    ),

    'date' => array(
        'id' => 'date',
        'label' => __( 'Date Settings', 'ninja-forms' ),
    ),

    'recaptcha' => array(
        'id' => 'recaptcha',
        'label' => __( 'reCaptcha Settings', 'ninja-forms' ),
    ),

    'advanced' => array(
        'id' => 'advanced',
        'label' => __( 'Advanced Settings', 'ninja-forms' ),
    ),

    'saved_fields' => array(
        'id' => 'saved_fields',
        'label' => __( 'Saved Fields', 'ninja-forms' ),
    ),

));
