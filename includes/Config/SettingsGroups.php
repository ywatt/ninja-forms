<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-field-settings-groups', array(

    'primary' => array(
        'id' => 'primary',
        'label' => '',
        'display' => TRUE
    ),

    'rte' => array(
        'id' => 'rte',
        'label' => __( 'Rich Text Editor (RTE)', 'ninja-forms' )
    ),

    'restrictions' => array(
        'id' => 'restrictions',
        'label' => __( 'Restrictions', 'ninja-forms' )
    ),

    'advanced' => array(
        'id' => 'advanced',
        'label' => __( 'Advanced', 'ninja-forms' )
    ),

    'administration' => array(
        'id' => 'administration',
        'label' => __( 'Administration', 'ninja-forms' )
    )

));
