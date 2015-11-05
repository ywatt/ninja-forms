<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-field-settings', array(

    /*
     * LABEL
     */

    'label' => array(
        'name' => 'label',
        'type' => 'textbox',
        'label' => __( 'Label', Ninja_Forms::TEXTDOMAIN ),
        'width' => 'one-half',
        'group' => 'primary'
    ),

    /*
     * PLACEHOLDER
     */

    'placeholder' => array(
        'name' => 'placeholder',
        'type' => 'textbox',
        'label' => __( 'Placeholder', Ninja_Forms::TEXTDOMAIN ),
        'width' => 'one-half'
    ),

    /*
     * LABEL POSITION
     */

    'label_pos' => array(
        'name' => 'label_pos',
        'type' => 'dropdown',
        'label' => __( 'Label Position', Ninja_Forms::TEXTDOMAIN ),
        'options' => array(
            'above'   => array(
                'label' => __( 'Above Element', Ninja_Forms::TEXTDOMAIN ),
                'value' => 'above'
            ),
            'below'   => array(
                'label' => __( 'Below of Element', Ninja_Forms::TEXTDOMAIN ),
                'value' => 'below'
            ),
            'left'   => array(
                'label' => __( 'Left of Element', Ninja_Forms::TEXTDOMAIN ),
                'value' => 'left'
            ),
            'right'   => array(
                'label' => __( 'Right of Element', Ninja_Forms::TEXTDOMAIN ),
                'value' => 'right'
            ),
            'hidden'   => array(
                'label' => __( 'Hidden', Ninja_Forms::TEXTDOMAIN ),
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
        'label' => __( 'Required Field', Ninja_Forms::TEXTDOMAIN ),
        'width' => 'one-half'
    ),
));
