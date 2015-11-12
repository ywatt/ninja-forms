<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-field-settings', array(

    /*
     * LABEL
     */

    'label' => array(
        'name' => 'label',
        'type' => 'textbox',
        'label' => __( 'Label', 'ninja-forms'),
        'width' => 'one-half',
        'group' => 'primary'
    ),

    /*
     * LABEL POSITION
     */

    'label_pos' => array(
        'name' => 'label_pos',
        'type' => 'select',
        'label' => __( 'Label Position', 'ninja-forms' ),
        'options' => array(
            array(
                'label' => __( 'Above Element', 'ninja-forms' ),
                'value' => 'above'
            ),
            array(
                'label' => __( 'Below of Element', 'ninja-forms' ),
                'value' => 'below'
            ),
            array(
                'label' => __( 'Left of Element', 'ninja-forms' ),
                'value' => 'left'
            ),
            array(
                'label' => __( 'Right of Element', 'ninja-forms' ),
                'value' => 'right'
            ),
            array(
                'label' => __( 'Hidden', 'ninja-forms' ),
                'value' => 'hidden'
            ),
        ),
        'width' => 'one-half',
        'group' => 'primary'
    ),

    /*
     * PLACEHOLDER
     */

    'placeholder' => array(
        'name' => 'placeholder',
        'type' => 'textbox',
        'label' => __( 'Placeholder', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary'
    ),

    /*
     * REQUIRED
     */

    'required' => array(
        'name' => 'required',
        'type' => 'toggle',
        'label' => __( 'Required Field', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary'
    ),


    'classes' => array(
        'name' => 'classes',
        'type' => 'fieldset',
        'label' => __( 'Custom Class Names', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'advanced',
        'settings' => array(
            array(
                'name' => 'wrapper_class',
                'type' => 'textbox',
                'placeholder' => '',
                'label' => __( 'Wrapper', 'ninja-forms' ),
                'width' => 'one-half'
            ),
            array(
                'name' => 'element_class',
                'type' => 'textbox',
                'label' => __( 'Element', 'ninja-forms' ),
                'placeholder' => '',
                'width' => 'one-half'
            ),
        ),
    ),

    /*
    * Checkbox Default Value
    */

    'checkbox_default_value' => array(
        'name' => 'default_value',
        'type' => 'select',
        'label' => __( 'Default Value', 'ninja-forms' ),
        'options' => array(
            array(
                'label' => __( 'Unchecked', 'ninja-forms' ),
                'value' => 'unchecked'
            ),
            array(
                'label' => __( 'Checked', 'ninja-forms'),
                'value' => 'checked',
            ),
        ),
        'width' => '',
        'group' => ''
    ),

    /*
    * Send Form Copy
    */

    //This field has a tool tip beside it in 2.9.x
    'send_form_copy' => array(
        'name' => 'send_email', //Send email was attached to the end of the form field in 2.9.x
        'type' => 'checkbox',
        'label' => __( 'Send a copy of the form to this address?', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

    /*
    * Spam Question
    */

    'spam_question' => array(
        'name' => 'spam_question',
        'type' => 'textbox',
        'label' => __( 'Spam Question', 'ninja-forms' ),
        'value' => __( 'Anti-Spam', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

    /*
    * Spam Answer
    */

    'spam_answer' => array(
        'name' => 'spam_answer',
        'type' => 'textbox',
        'label' => __( 'Spam Answer', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

    /*
    * Timed Submit Label
    */

    'timed_submit_label' => array(
        'name' => 'timed_submit_label',
        'type' => 'textbox',
        'label' => __( 'Label', 'ninja-forms' ),
        //The following text appears below the element
        //'Submit button text after timer expires'
        'width' => '',
        'group' => ''
    ),
    /*
    * Timed Submit Timer
    */

    'timed_submit_timer' => array(
        'name' => 'timed_submit_timer',
        'type' => 'textbox',
        'label' => __( 'Label' , 'ninja-forms' ),
        // This text was located below the element '%n will be used to signfify the number of seconds'
        'value' => __( 'Please wait %n seconds', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

    /*
    * Timed Submit Countdown
    */

    'timed_submit_countdown' => array (
        'name' => 'timed_submit_countdown',
        'type' => 'number',
        'label' => __( 'Number of seconds for the countdown', 'ninja-forms' ),
        //The following text appears to the right of the element
        //"This is how long the user must waitin to submit the form"
        'value' => 10,
        'width' => '',
        'group' => ''
    ),

    /*
    * Show Rich Text Editor
    */

    'rich_text_editor' => array(
        'name' => 'rich_text_editor',
        'type' => 'checkbox',
        'value' => 'unchecked',
    'label' => __( 'Show Rich Text Editor', 'ninja-forms' ),
    'width' => '',
    'group' => ''
    ),

      /*
      * Show Media Upload Button
      */

      'media_upload_button' => array(
        'name' => 'media_upload_button',
        'type' => 'checkbox',
        'value' => 'unchecked',
        'label' => __( 'Show Media Upload Button', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

      /*
      * Disable Mobile Rich Text Editor
      */

      'disable_moblile_rich_text_editor' => array(
        'name' => 'disable_mobile_rich_text_editor',
        'type' => 'checkbox',
        'value' => 'unchecked',
        'label' => __( 'Disable Rich Text Editor on Mobile', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

      /*
      * Password Registration checkbox
      */

      'password_registration_checkbox' => array(
        'name' => 'password_registration_checkbox',
        'type' => 'checkbox',
        'value' => 'unchecked',
        'label' => __( 'Use this as a reistration password field. If this box is check, both
                        password and re-password textboxes will be output', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),


      /*
      * Number of Stars Textbox
      */

      'number_of_stars' => array(
        'name' => 'number_of_stars',
        'type' => 'textbox',
        'value' => 5,
        'label' => __( 'Number of stars', 'ninja-forms' ),
        'width' => '',
        'group' => ''
        ),

      /*
      * Text Default Value
      */

      'text_default_value' => array(
        'name' => 'text_default_value',
        'type' => '',// TODO: WYSIWYG editor here
        'label' => __( 'Re-enter Password Label', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),
      /*
      * Disable Browser Autocomplete
      */

      'disable_browser_autocomplete' => array(
        'name' => 'disable_browser_autocomplete',
        'type' => 'checkbox',
        'value' => 'unchecked',
        'label' => __( 'Disable Browser Autocomplete', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

        //TODO: Ask about the list of states and countries.
      /*
      *  Country - Use Custom First Option
      */

      'use_custom_first_option' => array(
        'name' => 'use_custom_first_option',
        'type' => 'checkbox',
        'value' => 'unchecked',
        'label' => __( 'Use a custom first option', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

      /*
      * Country - Custom first option
      */

      'custom_first_option' => array(
        'name' => 'custom_first_option',
        'type' => 'textbox',
        'label' => __( 'Custom first option', 'ninja-forms' ),
        'width' => '',
        'group' => ''
    ),

));
