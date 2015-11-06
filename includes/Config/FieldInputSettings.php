<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-field-input-settings', array(

    /*
     * DEFAULT VALUE
     */


    array(
        'name'    => 'default',
        'type'    => 'fieldset',
        'label'   => __( 'Default Value', Ninja_Forms::TEXTDOMAIN ),
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
                        'label' => __( 'None', Ninja_Forms::TEXTDOMAIN )
                    ),
                    array(
                        'value' => 'post_id',
                        'label' => __( 'Post / Page ID', Ninja_Forms::TEXTDOMAIN )
                    ),
                    array(
                        'value' => 'post_title',
                        'label' => __( 'Post / Page Title', Ninja_Forms::TEXTDOMAIN )
                    ),
                    array(
                        'value' => 'post_url',
                        'label' => __( 'Post / Page URL', Ninja_Forms::TEXTDOMAIN )
                    ),
                    array(
                        'value' => 'query_string',
                        'label' => __( 'Query String Variable', Ninja_Forms::TEXTDOMAIN )
                    ),
                    array(
                        'value' => 'custom',
                        'label' => __( 'Custom Default Value', Ninja_Forms::TEXTDOMAIN )
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
