<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-field-settings', array(

    /*
     * LABEL
     */

    'label' => array(
        'name' => 'label',
        'type' => 'textbox',
        'label' => __( 'Label', 'ninja-forms'),
        'width' => 'one-half',
        'group' => 'primary'
    ),

    /*
     * PLACEHOLDER
     */

    'placeholder' => array(
        'name' => 'placeholder',
        'type' => 'textbox',
        'label' => __( 'Placeholder', 'ninja-forms' ),
        'width' => 'one-half'
    ),

    /*
     * LABEL POSITION
     */

    'label_pos' => array(
        'name' => 'label_pos',
        'type' => 'dropdown',
        'label' => __( 'Label Position', 'ninja-forms' ),
        'options' => array(
            'above'   => array(
                'label' => __( 'Above Element', 'ninja-forms' ),
                'value' => 'above'
            ),
            'below'   => array(
                'label' => __( 'Below of Element', 'ninja-forms' ),
                'value' => 'below'
            ),
            'left'   => array(
                'label' => __( 'Left of Element', 'ninja-forms' ),
                'value' => 'left'
            ),
            'right'   => array(
                'label' => __( 'Right of Element', 'ninja-forms' ),
                'value' => 'right'
            ),
            'hidden'   => array(
                'label' => __( 'Hidden', 'ninja-forms' ),
                'value' => 'hidden'
            ),
        ),
    ),

    /*
     * REQUIRED
     */

    'required' => array(
        'name' => 'required',
        'type' => 'toggle',
        'label' => __( 'Required Field', 'ninja-forms' ),
        'width' => 'one-half'
    ),
));
