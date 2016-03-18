<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_from_subs_display_settings', array(

    /*
     * Sub View Before
     */

    'sub_view_before' => array(
        'name' => 'sub_view_before',
        'type' => 'textarea',
        'label' => __( 'Views (Basic)', 'ninja-forms' ),
        'group' => 'primary',
        'width' => 'full',
        'value' => '',
        'use_merge_tags' => FALSE
    ),

    /*
     * Sub View
     */

    'sub_view' => array(
        'name' => 'sub_view',
        'type' => 'textarea',
        'label' => __( 'Views (Basic)', 'ninja-forms' ),
        'group' => 'primary',
        'width' => 'full',
        'value' => '',
        'use_merge_tags' => TRUE
    ),

    /*
     * Sub View After
     */

    'sub_view_after' => array(
        'name' => 'sub_view_after',
        'type' => 'textarea',
        'label' => __( 'Views (Basic)', 'ninja-forms' ),
        'group' => 'primary',
        'width' => 'full',
        'value' => '',
        'use_merge_tags' => FALSE
    ),

));
