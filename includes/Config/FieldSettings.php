<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
     * LABEL
     */

    'label' => array(
        'type' => 'text',
        'label' => __( 'Label', Ninja_Forms::TEXTDOMAIN ),
    ),

    /*
     * LABEL POSITION
     */

    'label_pos' => array(
        'type' => 'select',
        'label' => __( 'Label Position', Ninja_Forms::TEXTDOMAIN ),
        'options' => array(
            'left'   => __( 'Left of Element', Ninja_Forms::TEXTDOMAIN ),
            'right'  => __( 'Right of Element', Ninja_Forms::TEXTDOMAIN ),
            'above'  => __( 'Above Element', Ninja_Forms::TEXTDOMAIN ),
            'below'  => __( 'Below Element', Ninja_Forms::TEXTDOMAIN ),
            'inside' => __( 'Inside Element', Ninja_Forms::TEXTDOMAIN ),
        ),
    ),
);
