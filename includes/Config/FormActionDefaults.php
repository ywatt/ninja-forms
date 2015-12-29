<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-from-display-settings', array(

    array(
        'id' => 'tmp-1',
        'label' => 'Success Message',
        'type' => 'successmessage',
        'message' => 'This is a default success message',
        'active' => TRUE,
    ),

    array(
        'id' => 'tmp-2',
        'label' => 'Admin Email',
        'type' => 'email',
        'to' => array( 'myformbuildingbringsallthedeveloperstotheyard@wpninjas.com' ),
        'subject' => 'This is an email action.',
        'message' => 'Hello, Ninja Forms!',
        'active' => TRUE,
    ),

    array(
        'id' => 'tmp-3',
        'label' => 'Save Submission',
        'type' => 'save',
        'active' => TRUE,
    ),

));