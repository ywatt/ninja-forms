<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
     * Label
     */

    'label' => array(
        'name' => 'label',
        'type' => 'textbox',
        'group' => 'primary',
        'label' => __( 'Action Name', 'ninja-forms' ),
        'placeholder' => '',
        'width' => 'full',
        'value' => '',
        'use_merge_tags' => FALSE,
    ),    

    /*
     * Active
     */

    'active' => array(
        'name' => 'active',
        'type' => 'toggle',
        'label' => __( 'Active', 'ninja-forms' ),
        'value' => 1
    ),
);
