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

));
