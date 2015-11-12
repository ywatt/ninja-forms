<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
    * Format
    */

    'format' => array(
        'type' => 'select',
            'options' => array(
                'html' => __( 'HTML', 'ninja-forms' ),
                'plain' => __( 'Plain Text', 'ninja-forms' ),
            ),
        'label' => __( 'Format', 'ninja-forms' ),
        'placeholder' => '',
    ),

    /*
    * Reply To
    */

    'reply-to' => array(
        'type' => 'text',
        'label' => __( 'Reply To', 'ninja-forms' ),
        'placeholder' => '',
    ),

    /*
    * Cc
    */

    'cc' => array(
        'type' => 'text',
        'label' => __( 'Cc', 'ninja-forms' ),
        'placeholder' => '',
    ),

    /*
    * Bcc
    */

    'bcc' => array(
        'type' => 'text',
        'label' => __( 'Bcc', 'ninja-forms' ),
        'placeholder' => '',
    ),

    /*
    * Message
    */

    'message' => array(
        'type' => 'textarea',
        'label' => __( 'Message', 'ninja-forms' ),
        'placeholder' => '',
    ),

);
