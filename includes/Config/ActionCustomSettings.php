<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
     * Hook
     */

    'hook' => array(
        'name' => 'hook',
        'type' => 'select',
            'options' => array(
                array(
                    'value' => 'action',
                    'label' => __( 'Action', 'ninja-forms'),
                ),
                array(
                    'value' => 'filter',
                    'label' => __( 'Filter', 'ninja-forms'),
                ),
            ),
        'group' => 'primary',
        'label' => __( 'Hook', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),

    /*
     * Tag
     */

    'tag' => array(
        'name' => 'tag',
        'type' => 'textbox',
        'group' => 'primary',
        'label' => __( 'Tag', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),
    
);