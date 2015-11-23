<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-from-settings', array(

    /**
     * DISPLAY
     */

    /*
     * FORM TITLE
     */

    'form-title' => array(
        'name' => 'form-title',
        'type' => 'textbox',
        'label' => __( 'Form Title', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => ''
    ),

    /*
     * DISPLAY FORM TITLE
     */

    'display-form-title' => array(
        'name' => 'display-form-title',
        'type' => 'toggle',
        'label' => __( 'Display Form Title', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => 'true'
    ),

    /*
     * ADD FORM TO THIS PAGE
     */

    'add-form-to-this-page' => array(
        'name' => 'add-form-to-this-page',
        'type' => 'select',
        'label' => __( 'Add form to this page', 'ninja-forms' ),
        'options' => array(
            array(
                'label' => __( '- None', 'ninja-forms' ),
                'value' => 'default',
            ),
        ),
        'width' => 'full',
        'group' => 'primary',
        'value' => ''
    ),

    /*
     * CLEAR SUCCESSFULLY COMPLETED FORM
     */

    'clear-successfully-created-form' => array(
        'name' => 'clear-successfully-created-form',
        'type' => 'toggle',
        'label' => __( 'Clear successfully completed form?', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => 'true'
        //TODO: Add following text below the element.
        //If this box is checked, Ninja Forms will clear the form values after it has been successfully submitted.
    ),

    /*
     * HIDE SUCCESSFULLY COMPLETED FORMS
     */

    'hide-successfully-completed-form' => array(
        'name' => 'hide-successfully-completed-form',
        'type' => 'toggle',
        'label' => __( 'Hide successfully completed forms?', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => 'true'
        //TODO: Add following text below the element.
        //If this box is checked, Ninja Forms will hide the form after it has been successfully submitted.
    ),

    /**
     * RESTRICTIONS
     */

    /*
     * REQUIRE USER TO BE LOGGED IN TO VIEW FORM?
     */

    'require-user-logged-in-to-view-form' => array(
        'name' => 'require-user-logged-in-to-view-form',
        'type' => 'toggle',
        'label' => __( 'Require user to be logged in to view form?', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => 'true'
    ),

    /*
     * NOT LOGGED-IN MESSAGE
     */

    'not-logged-in-message' => array(
        'name' => 'not-logged-in-message',
        'type' => '', //TODO: Add WYSIWYG
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
        'type' => '',//TODO: Add WYSIWYG
        'label' => __( 'Limit Reached Message', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'value' => ''
        //TODO: Add following text below the WYSIWYG.
        //Please enter a message that you want displayed when this form has reached its submission limit and will not
        //accept new submissions.
    ),

));
