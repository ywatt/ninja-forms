<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_merge_tags_form', array(

    /*
    |--------------------------------------------------------------------------
    | Submission Sequence Number
    |--------------------------------------------------------------------------
    */

    'sub_seq' => array(
        'id' => 'sub_seq',
        'tag' => '{form:sub_seq}',
        'label' => __( 'Sub Sequence', 'ninja_forms' ),
        'callback' => 'get_sub_seq',
    ),

));