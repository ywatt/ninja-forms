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
    * From Name
    */

    'from-name' => array(
        'type' => 'text',
        'label' => __( 'From Name', 'ninja-forms' ),
        'placeholder' => __( 'Name or fields', 'ninja-forms' ),
    ),

    /*
    * From Address
    */

    'from-address' => array(
        'type' => 'text',
        'label' => __( 'From Address', 'ninja-forms' ),
        'placeholder' => __( 'One email address or field', 'ninja-forms' ),
    ),

    /*
     * To
     */

    'to' => array(
        'type' => 'text',
        'label' => __( 'To', 'ninja-forms' ),
        'placeholder' => __( 'Email address or search for a field', 'ninja-forms' ),
    ),

    /*
    * Subject
    */

    'subject' => array(
        'type' => 'text',
        'label' => __( 'Subject', 'ninja-forms' ),
        'placeholder' => __( 'Subject Text or seach for a field', 'ninja-forms' ),
    ),

    /*
    * Email Message
    */

    'email-message' => array(
        'type' => 'textarea',
        'label' => __( 'Email Message', 'ninja-forms' ),
        'placeholder' => '',
    ),

    /*
    * Advanced Settings
    */

    'format' => array(
        'type' => 'select',
            'options' => array(
                'html' => __( 'HTML', 'ninja-forms' ),
                'plain' => __( 'Plain Text', 'ninja-forms' ),
            ),
        'group' => 'advanced',
        'label' => __( 'Format', 'ninja-forms' ),
        'placeholder' => '',
    ),

    'reply-to' => array(
        'type' => 'text',
        'group' => 'advanced',
        'label' => __( 'Reply To', 'ninja-forms' ),
        'placeholder' => '',
    ),

    'cc' => array(
        'type' => 'text',
        'group' => 'advanced',
        'label' => __( 'Cc', 'ninja-forms' ),
        'placeholder' => '',
    ),

    'bcc' => array(
        'type' => 'text',
        'group' => 'advanced',
        'label' => __( 'Bcc', 'ninja-forms' ),
        'placeholder' => '',
    ),

);
