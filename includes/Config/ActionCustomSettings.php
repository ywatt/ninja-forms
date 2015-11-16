<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
     * Hook
     */

    'hook' => array(
        'type' => 'Select',
            'options' => array(
                'action' => __( 'Action', 'ninja-forms'),
                'filter' => __( 'Filter', 'ninja-forms' ),
            ),
        'label' => __( 'Hook', 'ninja-forms' ),
        'placeholder' => '',
    ),

    /*
     * Tag
     */

    'tag' => array(
        'type' => 'text',
        'label' => __( 'Tag', 'ninja-forms' ),
        'placeholder' => '',
    ),
    
);
