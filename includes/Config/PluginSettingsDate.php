<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_plugin_settings_date', array(

    /*
    |--------------------------------------------------------------------------
    | Date Format
    |--------------------------------------------------------------------------
    */

    'date_format' => array(
        'id'    => 'date_format',
        'type'  => 'textbox',
        'label' => __( 'Date Format', 'ninja-forms' ),
        'desc'  => 'e.g. m/d/Y, d/m/Y - ' . sprintf( __( 'Tries to follow the %sPHP date() function%s specifications, but not every format is supported.', 'ninja-forms' ), '<a href="http://www.php.net/manual/en/function.date.php" target="_blank">', '</a>' ),
    ),


    /*
    |--------------------------------------------------------------------------
    | Datepicker Labels
    |--------------------------------------------------------------------------
    */

    /*
    'date_label_january' => array(
        'id'    => 'date_label_january',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'January', 'ninja-forms' ),
        'default'
    ),

    'date_label_february' => array(
        'id'    => 'date_label_february',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'February', 'ninja-forms' ),
    ),

    'date_label_march' => array(
        'id'    => 'date_label_march',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'March', 'ninja-forms' ),
    ),

    'date_label_april' => array(
        'id'    => 'date_label_april',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'April', 'ninja-forms' ),
    ),

    'date_label_may' => array(
        'id'    => 'date_label_may',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'May', 'ninja-forms' ),
    ),

    'date_label_june' => array(
        'id'    => 'date_label_june',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'June', 'ninja-forms' ),
    ),

    'date_label_july' => array(
        'id'    => 'date_label_july',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'July', 'ninja-forms' ),
    ),

    'date_label_august' => array(
        'id'    => 'date_label_august',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'August', 'ninja-forms' ),
    ),

    'date_label_september' => array(
        'id'    => 'date_label_september',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'September', 'ninja-forms' ),
    ),

    'date_label_october' => array(
        'id'    => 'date_label_october',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'October', 'ninja-forms' ),
    ),

    'date_label_november' => array(
        'id'    => 'date_label_november',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'November', 'ninja-forms' ),
    ),

    'date_label_december' => array(
        'id'    => 'date_label_december',
        'type'  => 'textbox',
        'label' => __( 'Month Label', 'ninja-forms' ) . ': ' . __( 'December', 'ninja-forms' ),
    ),
    */

));
