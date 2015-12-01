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
        'group' => 'primary',
        'value' => '',
        'help' => __( 'Enter the label of the form field. This is how users will identify individual fields.', 'ninja-forms' ),
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
                'label' => __( 'Form Default', 'ninja-forms' ),
                'value' => 'default'
            ),
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
        'group' => 'primary',
        'value' => 'above',
        'help' => __( 'Select the position of your label relative to the field element itself.', 'ninja-forms' ),
    ),

    /*
     * INPUT PLACEHOLDER
     */

    'placeholder' => array(
        'name' => 'placeholder',
        'type' => 'textbox',
        'label' => __( 'Placeholder', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'advanced',
        'value' => '',
        'help' => __( 'Enter text you would like displayed in the field before a user enters any data.', 'ninja-forms' ),
    ),

    /*
     * REQUIRED
     */

    'required' => array(
        'name' => 'required',
        'type' => 'toggle',
        'label' => __( 'Required Field', 'ninja-forms' ),
        'width' => 'one-half',
        'group' => 'primary',
        'value' => FALSE,
        'help' => __( 'Ensure that this field is completed before allowing the form to be submitted.', 'ninja-forms' ),
    ),

    /*
     * NUMBER
     */

    'number' => array(
        'name' => 'number',
        'type' => 'fieldset',
        'label' => __( 'Number Options', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'settings' => array(
            array(
                'name' => 'num_min',
                'type' => 'textbox',
                'placeholder' => '',
                'label' => __( 'Min', 'ninja-forms' ),
                'width' => 'one-third',
                'value' => ''
            ),
            array(
                'name' => 'num_max',
                'type' => 'textbox',
                'label' => __( 'Max', 'ninja-forms' ),
                'placeholder' => '',
                'width' => 'one-third',
                'value' => ''
            ),
            array(
                'name' => 'num_step',
                'type' => 'textbox',
                'label' => __( 'Step', 'ninja-forms' ),
                'placeholder' => '',
                'width' => 'one-third',
                'value' => 1
            ),
        ),
    ),

    /*
     * DEFAULT VALUE
     */


     'default' => array(
         'name'    => 'default',
         'type'    => 'fieldset',
         'label'   => __( 'Default Value', 'ninja-forms' ),
         'width' => 'full',
         'group' => 'advanced',
         'value' => 'none',
         'settings' => array(
             'default_type' => array(
                 'name' => 'default_type',
                 'label' => 'Type',
                 'type' => 'select',
                 'options' => array(
                     array(
                         'value' => 'none',
                         'label' => __( 'None', 'ninja-forms' )
                     ),
                     array(
                         'value' => 'post_id',
                         'label' => __( 'Post / Page ID', 'ninja-forms' )
                     ),
                     array(
                         'value' => 'post_title',
                         'label' => __( 'Post / Page Title', 'ninja-forms' )
                     ),
                     array(
                         'value' => 'post_url',
                         'label' => __( 'Post / Page URL', 'ninja-forms' )
                     ),
                     array(
                         'value' => 'query_string',
                         'label' => __( 'Query String Variable', 'ninja-forms' )
                     ),
                     array(
                         'value' => 'custom',
                         'label' => __( 'Custom Default Value', 'ninja-forms' )
                     )
                 ),
             ),
             array(
                 'name' => 'default_value',
                 'label' => 'Value',
                 'type' => 'textbox',
                 'width' => 'one-half',
                 'value' => ''
             )
         )
     ),

    /*
    * CLASSES
    */


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
                'width' => 'one-half',
                'value' => ''
            ),
            array(
                'name' => 'element_class',
                'type' => 'textbox',
                'label' => __( 'Element', 'ninja-forms' ),
                'placeholder' => '',
                'width' => 'one-half',
                'value' => ''
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
         'width' => 'one-half',
         'group' => 'primary',
         'value' => 'unchecked'
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
        'group' => '',
        'value' => ''
    ),

   /*
    * Spam Answer
    */

    'spam_answer' => array(
        'name' => 'spam_answer',
        'type' => 'textbox',
        'label' => __( 'Spam Answer', 'ninja-forms' ),
        'width' => '',
        'group' => '',
        'value' => ''
    ),

   /*
    * Timed Submit Label
    */

   // 'timed_submit' => array(
   //      'name' => 'timed_submit',
   //      'type' => 'fieldset',
   //      'label' => __( 'Timed Submit', 'ninja-forms' ),
   //      'width' => 'full',
   //      'group' => 'advanced',
   //      'settings' => array(
   //          array(
   //              'name' => 'timed_submit_countdown',
   //              'type' => 'number',
   //              'label' => __( 'Countdown', 'ninja-forms' ),
   //              'value' => 10,
   //              'placeholder' => '',
   //              'width' => 'one-half',
   //          ),
   //          array(
   //              'name' => 'timed_submit_label',
   //              'type' => 'textbox',
   //              'placeholder' => '',
   //              'label' => __( 'Timer Label', 'ninja-forms' ),
   //              'value' => __( 'Please wait %n seconds', 'ninja-forms' ),
   //              'width' => 'one-half'
   //          ),
   //      ),
   //  ),

                'timed_submit_label' => array(
                    'name' => 'timed_submit_label',
                    'type' => 'textbox',
                    'label' => __( 'Label', 'ninja-forms' ),
                    //The following text appears below the element
                    //'Submit button text after timer expires'
                    'width' => '',
                    'group' => '',
                    'value' => ''
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

    // 'rte_enable' => array(
    //     'name' => 'rte_enable', // TODO was rich_text_editor
    //     'type' => 'toggle',
    //     'label' => __( 'Enable RTE', 'ninja-forms' ),
    //     'width' => 'one-half',
    //     'group' => 'rte',
    //     'value' => FALSE
    // ),

    // 'rte_media' => array(
    //     'name' => 'rte_media', // TODO was media_upload_button
    //     'type' => 'toggle',
    //     'label' => __( 'Enable Media Button', 'ninja-forms' ),
    //     'width' => 'one-half',
    //     'group' => 'rte',
    //     'value' => FALSE
    // ),

    // 'rte_mobile' => array(
    //     'name' => 'rte_mobile', // TODO was disable_moblile_rich_text_editor
    //     'type' => 'toggle',
    //     'label' => __( 'Mobile Friendly', 'ninja-forms' ),
    //     'width' => 'one-half',
    //     'group' => 'rte',
    //     'value' => FALSE
    // ),

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

    // 'textarea_default_value' => array(
    //     'name' => 'text_default_value',
    //     'type' => 'textarea',// TODO: WYSIWYG editor here
    //     'label' => __( 'Default Value', 'ninja-forms' ),
    //     'width' => 'full',
    //     'group' => 'advanced'
    //     'value' => ''
    // ),

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
        'group' => '',
        'value' => FALSE
    ),

    /*
     * DATEPICKER
     */

    'datepicker' => array(
        'name' => 'datepicker',
        'type' => 'toggle',
        'label' => __( 'Use the JQueryUI datepicker.', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'advanced',
        'value' => FALSE
    ),

    /*
     * OPTIONS
     */

    'options' => array(
        'name' => 'options',
        'type' => 'list-repeater',
        'label' => __( 'Options', 'ninja-forms' ) . ' <a href="#" class="nf-add-new">' . __( 'Add New', 'ninja-forms' ) . '</a>',
        'width' => 'full',
        'group' => 'primary',
        'value' => FALSE
    ),

    /*
     * TIME SETTING
     */

    'time_submit' => array(
        'name' => 'time_submit',
        'type' => 'textbox',
        'label' => __( 'Number of seconds for timed submit.', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'advanced',
        'value' => FALSE
    ),

    /*
     * MASK
     */

    // 'mask' => array(
    //     'name' => 'mask',
    //     'type' => 'select',
    //     'label' => __( 'Input Mask', 'ninja-forms'),
    //     'width' => 'one-half',
    //     'group' => 'restrictions',
    //     'options' => array(
    //         array(
    //             'label' => __( 'none', 'ninja-forms' ),
    //             'value' => ''
    //         ),
    //         array(
    //             'label' => __( 'US Phone', 'ninja-forms' ),
    //             'value' => 'us-phone'
    //         ),
    //         array(
    //             'label' => __( 'Date', 'ninja-forms' ),
    //             'value' => 'date'
    //         ),
    //     )
    //     'value' => ''
    // ),

    /*
     * INPUT LIMIT SET
     */

    // 'input_limit_set' => array(
    //     'name' => 'input_limit_set',
    //     'type' => 'fieldset',
    //     'label' => __( 'Limit Input to this Number', 'ninja-forms' ),
    //     'width' => 'full',
    //     'group' => 'restrictions',
    //     'settings' => array(
    //         array(
    //             'name' => 'input_limit',
    //             'type' => 'textbox',
    //             'placeholder' => 150,
    //             'width' => 'one-half',
    //             'value' => ''
    //         ),
    //         array(
    //             'name' => 'input_limit_type',
    //             'type' => 'select',
    //             'options' => array(
    //                 array(
    //                     'label' => __( 'Character(s)', 'ninja-forms' ),
    //                     'value' => 'characters'
    //                 ),
    //                 array(
    //                     'label' => __( 'Word(s)', 'ninja-forms' ),
    //                     'value' => 'words'
    //                 ),
    //             ),
    //             'value' => 'characters'
    //         ),
    //         array(
    //             'name' => 'input_limit_message',
    //             'type' => 'textbox',
    //             'label' => __( 'Text to Appear After Counter', 'ninja-forms' ),
    //             'placeholder' => __( 'Character(s) left' ),
    //             'width' => 'full',
    //             'value' => __( 'Character(s) left' )
    //         )
    //     )
    // ),

));


// Example of settings

// Add all core settings. Fields can unset if unneeded.
// $this->_settings = $this->load_settings(
//     array( 'label', 'label_pos', 'required', 'number', 'spam_question', 'mask', 'input_limit_set','rich_text_editor', 'placeholder', 'textare_placeholder', 'default', 'checkbox_default_value', 'classes', 'timed_submit' )
// );
