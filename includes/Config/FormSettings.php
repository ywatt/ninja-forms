<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-from-settings', array(

    /*
     * {NAME}
     */

    '{name}' => array(
        'name' => '{name}',
        'type' => '{textbox|select|toggle|etc}',
        'label' => __( '{Name}', 'ninja-forms'),
        'width' => 'full',
        'group' => 'primary',
        'value' => ''
    ),

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
    ),

    /*
     *
     */


));
