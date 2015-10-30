<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
     * Name
     */

    'name' => array(
        'type' => 'text',
        'label' => __( 'Action Name', 'ninja-forms' ),
        'placeholder' => '',
    ),

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
    * URL
    */

    'url' => array(
        'type' => 'text',
        'label' => __( 'URL', 'ninja-forms' ),
        'placeholder' => '',
    ),

);
