<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-field-input-settings', array(

    /*
     * DEFAULT VALUE
     */

    array(
        'name'    => 'default',
        'type'    => 'select',
        'label'   => __( 'Default to User Email (if logged-in)', Ninja_Forms::TEXTDOMAIN ),
        'options' => array(
            array(
                'value' => 'none',
                'name' => __( 'None', Ninja_Forms::TEXTDOMAIN )
            ),
            array(
                'value' => 'post_id',
                'name' => __( 'Post / Page ID', Ninja_Forms::TEXTDOMAIN )
            ),
            array(
                'value' => 'post_title',
                'name' => __( 'Post / Page Title', Ninja_Forms::TEXTDOMAIN )
            ),
            array(
                'value' => 'post_url',
                'name' => __( 'Post / Page URL', Ninja_Forms::TEXTDOMAIN )
            ),
            array(
                'value' => 'query_string',
                'name' => __( 'Query String Variable', Ninja_Forms::TEXTDOMAIN )
            ),
            array(
                'value' => 'custom',
                'name' => __( 'Custom Default Value', Ninja_Forms::TEXTDOMAIN )
            )
        ),
        'width' => 'one-half',
        'group' => 'primary'
    ),

));
