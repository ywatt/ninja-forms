<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-from-restriction-settings', array(

    /*
     * REQUIRE USER TO BE LOGGED IN TO VIEW FORM?
     */

    'require-user-logged-in-to-view-form' => array(
        'name' => 'require-user-logged-in-to-view-form',
        'type' => 'toggle',
        'label' => __( 'Require user to be logged in to view form?', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'value' => TRUE
    ),

    /*
     * NOT LOGGED-IN MESSAGE
     */

    'not-logged-in-message' => array(
        'name' => 'not-logged-in-message',
        'type' => 'textarea', //TODO: Add WYSIWYG
        'label' => __( 'Not Logged-In Message', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => ''
        //TODO: Add following text below the WYSIWYG.
        //Message shown to users if the "logged in" checkbox above is checked and they are not logged-in.
    ),

    /*
     * LIMIT SUBMISSIONS
     */

    'limit-submissions' => array(
        'name' => 'limit-submissions',
        'type' => 'textbox',
        'label' => __( 'Limit Submission', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => ''
        //TODO: Add following text below the element.
        //Select the number of submissions that this form will accept. Leave empty for no limit.
    ),

    /*
     * LIMIT REACHED MESSAGE
     */

    'limit-reached-message' => array(
        'name' => 'limit-reached-message',
        'type' => 'textarea',//TODO: Add WYSIWYG
        'label' => __( 'Limit Reached Message', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => ''
        //TODO: Add following text below the WYSIWYG.
        //Please enter a message that you want displayed when this form has reached its submission limit and will not
        //accept new submissions.
    ),

));
