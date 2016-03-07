<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_from_display_settings', array(

    array(
        'id'      => 'tmp-1',
        'label'   => 'Success Message',
        'type'    => 'successmessage',
        'message' => 'This is a default success message',
        'order'   => 1,
        'active'  => TRUE,
    ),

    array(
        'id'      => 'tmp-2',
        'label'   => 'Admin Email',
        'type'    => 'email',
        'to'      => array( get_option( 'admin_email' ) ),
        'subject' => 'This is an email action.',
        'message' => 'Hello, Ninja Forms!',
        'order'   => 2,
        'active'  => TRUE,
    ),

    array(
        'id'    => 'tmp-3',
        'label' => 'Save Submission',
        'type'  => 'save',
        'order' => 3,
        'active'=> TRUE,
    ),

));