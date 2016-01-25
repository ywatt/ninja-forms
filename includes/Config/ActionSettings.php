<?php if ( ! defined( 'ABSPATH' ) ) exit;

return array(

    /*
     * Label
     */

    'label' => array(
        'name' => 'label',
        'type' => 'textbox',
        'group' => 'primary',
        'label' => __( 'Action Name', 'ninja-forms' ),
        'placeholder' => '',
        'width' => 'full',
        'value' => '',
        
    ),    

    /*
     * Active
     */

    'active' => array(
        'name' => 'active',
        'type' => 'toggle',
        'label' => __( 'Active', 'ninja-forms' ),
        'value' => 1
    ),

    /*
     * Mapping Field
     */

    'field_map' => array(
        'name' => 'field_map',
        'type' => 'option-repeater',
        'label' => ' <a href="#" class="nf-add-new">' . __( 'Add New Field Map', 'ninja-forms' ) . '</a>',
        'width' => 'full',
        'group' => 'primary',
        'tmpl_row' => 'nf-tmpl-field-map-repeater-row',
        'use_merge_tags' => array(
            'exclude' => array(
                'user', 'system', 'post'
            ),
        ),
        'columns' => array(
            'form_field' => array(
                'header' => __( 'Form Field', 'ninja-forms' ),
                'default' => '',
            ),
            'map_field' => array(
                'header' => __( 'Map Field', 'ninja-forms' ),
                'default' => '',
                'options' =>array(),
            ),
        ),
    ),

);
