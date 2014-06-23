<?php
/**
 * Text field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Text extends NF_Field_Base {

	var $sidebar = 'general';
	
	/**
	 * Get things started.
	 * Set our nicename.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->nicename = __( 'Single Line Text', 'ninja-forms' );

		$restrictions = apply_filters( 'nf_text_restrictions_settings', array(
			'mask' 					=> array(
				'id' 				=> 'mask',
				'type' 				=> 'select',
				'name' 				=> __( 'Input Mask', 'ninja-forms' ),
				'desc' 				=> '',
				'help_text' 		=> '',
				'std' 				=> '',
				'options'			=> array(
					array( 'name' 	=> __( 'None', 'ninja-forms' ), 'value' => '' ),
				),
			),
			'input_limit' 			=> array(
				'id' 				=> 'input_limit',
				'type' 				=> 'number',
				'name' 				=> __( 'Limit Input To', 'ninja-forms' ),
				'desc' 				=> __( 'Leave blank for no limit', 'ninja-forms' ),
				'help_text' 		=> '',
				'std' 				=> '',
			),
			'input_limit_type'		=> array(
				'id' 				=> 'input_limit_type',
				'type' 				=> 'select',
				'name' 				=> __( 'Characters', 'ninja-forms' ),
				'desc' 				=> __( 'What do you want to limit?', 'ninja-forms' ),
				'help_text' 		=> '',
				'std' 				=> '',
				'options'			=> array(
					array( 'name' => __( 'Characters', 'ninja-forms' ), 'value' => 'char' ),
					array( 'name' => __( 'Words', 'ninja-forms' ), 'value' => 'word' ),
				),
			),
			'input_limit_msg'		=> array(
				'id' 				=> 'input_limit_msg',
				'type' 				=> 'text',
				'name' 				=> __( 'Text to appear after character/word counter', 'ninja-forms' ),
				'desc' 				=> '',
				'help_text' 		=> '',
				'std' 				=> __( 'Character(s) left', 'ninja-forms' ),
			),

		) );

		foreach( $restrictions as $slug => $setting ) {
			$this->registered_settings['restrictions'][ $slug ] = $setting;
		}

		$label_settings = apply_filters( 'nf_text_display_settings', array(
			'placeholder'			=> array(
				'id' 				=> 'placeholder',
				'type' 				=> 'text',
				'name' 				=> __( 'Placeholder Text', 'ninja-forms' ),
				'desc' 				=> '',
				'help_text' 		=> '',
				'std' 				=> '',
			),
		) );

		foreach ( $label_settings as $slug => $settings ) {
			$this->registered_settings['display'][ $slug ] = $settings;
		}

		do_action( 'nf_text_construct', $this );
	}
	
	/**
	 * Function that renders the textbox itself
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {

		if ( $this->settings['label_pos'] == 'inside' ) {
			$this->placeholder = $this->settings['label'];
		} else if ( isset ( $this->settings['placeholder'] ) ) {
			$this->placeholder = $this->settings['placeholder'];
		}

		$html = '<input type="text" name="' . $this->element_id . '" value="' . $this->value . '" class="' . $this->settings['class'] . '" placeholder="' . $this->placeholder . '"/>';
		echo $html;
	}

	/**
	 * Output our disabled element for the fields list.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		$html ='<input type="text" class="widefat" value="" disabled>';
		echo $html;
	}

}
