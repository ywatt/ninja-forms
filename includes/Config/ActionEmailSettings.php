<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
    * From Name
    */

    'from_name' => array(
        'name' => 'from_name',
        'type' => 'textbox',
        'group' => 'primary',
        'label' => __( 'From Name', 'ninja-forms' ),
        'placeholder' => __( 'Name or fields', 'ninja-forms' ),
        'value' => '',
        'width' => 'full'
    ),

    /*
    * Reply To
    */

    'reply-to' => array(
        'name' => 'replyto',
        'type' => 'textbox',
        'group' => 'primary',
        'label' => __( 'Reply To', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),

    /*
     * To
     */

    'to' => array(
        'name' => 'to',
        'type' => 'textbox',
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
        'type' => 'textbox',
        'group' => 'primary',
        'label' => __( 'Subject', 'ninja-forms' ),
        'placeholder' => __( 'Subject Text or seach for a field', 'ninja-forms' ),
        'value' => '',
        'width' => 'full'
    ),

    /*
    * Email Message
    */

    'email-message' => array(
        'name' => 'email_message',
        'type' => 'textarea',
        'group' => 'primary',
        'label' => __( 'Email Message', 'ninja-forms' ),
        'placeholder' => '',
        'value' => '',
        'width' => 'full'
    ),

     /*
    * From Address
    */

    'from-address' => array(
        'type' => 'textbox',
        'group' => 'advanced',
        'label' => __( 'From Address', 'ninja-forms' ),
        'placeholder' => __( 'One email address or field', 'ninja-forms' ),
        'value' => ''
    ),

    /*
    * Format
    */

    'format' => array(
        'name' => 'format',
        'type' => 'select',
            'options' => array(
                array( 'label' => __( 'HTML', 'ninja-forms' ), 'value' => 'html' ),
                array( 'label' => __( 'Plain Text', 'ninja-forms' ), 'value' => 'plain' )
            ),
        'group' => 'advanced',
        'label' => __( 'Format', 'ninja-forms' ),
        'value' => 'plain'
    ),

    /*
    * Cc
    */

    'cc' => array(
        'name' => 'cc',
        'type' => 'textbox',
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
        'type' => 'textbox',
        'group' => 'advanced',
        'label' => __( 'Bcc', 'ninja-forms' ),
        'placeholder' => '',
        'value' => ''
    ),

);
