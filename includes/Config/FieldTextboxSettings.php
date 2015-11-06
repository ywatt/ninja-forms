<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja-forms-textbox-settings', array(

    /*
     * MASK
     */

    'mask' => array(
        'name' => 'mask',
        'type' => 'dropdown',
        'label' => __( 'Input Mask', 'ninja-forms'),
        'width' => 'one-half',
        'group' => 'restrictions',
        'options' => array(
            'us-phone' => array(
                'label' => __( 'US Phone', 'ninja-forms' ),
                'value' => 'us-phone'
            ),
            'date' => array(
                'label' => __( 'Date', 'ninja-forms' ),
                'value' => 'date'
            ),
        )
    ),

    /*
     * INPUT LIMIT SET
     */

    'input_limit_set' => array(
        'name' => 'input_limit_set',
        'type' => 'fieldset',
        'label' => __( 'Limit Input to this Number', 'ninja-forms' ),
        'width' => 'full',
		'group' => 'restrictions',
        'settings' => array(
            'input_limit' => array(
				'name' => 'input_limit',
				'type' => 'textbox',
				'placeholder' => 150,
				'width' => 'one-half'
            ),
			'input_limit_type' => array(
				'name' => 'input_limit_type',
				'type' => 'dropdown',
				'options' => array(
					'characters' => array(
						'label' => __( 'Character(s)', 'ninja-forms' ),
						'value' => 'characters'
					),
					'words' => array(
						'label' => __( 'Word(s)', 'ninja-forms' ),
						'value' => 'words'
					),
				)
			),
			'input_limit_message' => array(
				'name' => 'input_limit_message',
				'type' => 'textbox',
				'label' => __( 'Text to Appear After Counter', 'ninja-forms' ),
				'placeholder' => __( 'Character(s) left' ),
				'width' => 'full'
			)
        )
    ),

) );
