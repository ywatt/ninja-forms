<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-field-input-settings', array(

    /*
     * DEFAULT VALUE
     */


    array(
        'name'    => 'default',
        'type'    => 'fieldset',
        'label'   => __( 'Default Value', 'ninja-forms' ),
        'width' => 'full',
        'group' => 'primary',
        'settings' => array(
            array(
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
                'width' => 'one-half'
            )
        )
    ),

));
