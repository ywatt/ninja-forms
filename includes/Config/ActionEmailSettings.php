<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
    * From Name
    */

    'from-name' => array(
        'name' => 'from-name',
        'type' => 'text',
        'group' => 'primary',
        'label' => __( 'From Name', 'ninja-forms' ),
        'placeholder' => __( 'Name or fields', 'ninja-forms' ),
        'value' => ''
    ),

    /*
    * From Address
    */

    'from-address' => array(
        'name' => 'from-address',
        'type' => 'text',
        'group' => 'primary',
        'label' => __( 'From Address', 'ninja-forms' ),
        'placeholder' => __( 'One email address or field', 'ninja-forms' ),
        'value' => ''
    ),

    /*
     * To
     */

    'to' => array(
        'name' => 'to',
        'type' => 'text',
        'group' => 'primary',
        'label' => __( 'To', 'ninja-forms' ),
        'placeholder' => __( 'Email address or search for a field', 'ninja-forms' ),
        'value' => ''
    ),

    /*
    * Subject
    */

    'subject' => array(
        'name' => 'subject',
        'type' => 'text',
        'group' => 'primary',
        'label' => __( 'Subject', 'ninja-forms' ),
        'placeholder' => __( 'Subject Text or seach for a field', 'ninja-forms' ),
        'value' => ''
    ),

    /*
    * Email Message
    */

    'email-message' => array(
        'name' => 'email-message',
        'type' => 'textarea',
        'group' => 'primary',
        'label' => __( 'Email Message', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),

    /*
    * Format
    */

    'format' => array(
        'name' => 'format',
        'type' => 'select',
            'options' => array(
                'html' => __( 'HTML', 'ninja-forms' ),
                'plain' => __( 'Plain Text', 'ninja-forms' ),
            ),
        'group' => 'advanced',
        'label' => __( 'Format', 'ninja-forms' ),
        'value' => 'plain'
    ),

    /*
    * Reply To
    */

    'reply-to' => array(
        'name' => 'reply-to',
        'type' => 'text',
        'group' => 'advanced',
        'label' => __( 'Reply To', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),

    /*
    * Cc
    */

    'cc' => array(
        'name' => 'cc',
        'type' => 'text',
        'group' => 'advanced',
        'label' => __( 'Cc', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),

    /*
    * Bcc
    */

    'bcc' => array(
        'name' => 'bcc',
        'type' => 'text',
        'group' => 'advanced',
        'label' => __( 'Bcc', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),

);
