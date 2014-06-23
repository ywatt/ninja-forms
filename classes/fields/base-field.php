<?php
/**
 * Base field class
 * All other field classes extend this one.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Base {

	// Setup our class variables. These can be overwritten by child classes.

	/**
	 * @var sidebar
	 * @since 3.0
	 */
	var $sidebar = '';

	/**
	 * @var settings_sections
	 * @since 3.0
	 */
	var $settings_sections = array();

	/**
	 * @var registered_settings
	 * @since 3.0
	 */
	var $registered_settings = array();

	/**
	 * @var default settings
	 * @since 3.0
	 */
	var $settings = array( 'label_pos' => 'left', 'class' => 'nf-field' );

	/**
	 * @var nicename
	 * @since 3.0
	 */
	var $nicename = '';

	/**
	 * @var field_id
	 * @since 3.0
	 */
	var $field_id = '';

	/**
	 * @var field_id
	 * @since 3.0
	 */
	var $element_id = '';

	/**
	 * @var value
	 * @since 3.0
	 */
	var $value = false;

	/**
	 * @var label
	 * @since 3.0
	 */
	var $div_wrapper = true;	

	/**
	 * @var label
	 * @since 3.0
	 */
	var $placeholder = '';

	/**
	 * @var add_to_sub
	 * @since 3.0
	 */
	var $add_to_sub = true;

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		// Register our default field settings sidebars
		$this->settings_sections['display'] = __( 'Display', 'ninja-forms' );
		$this->settings_sections['restrictions'] = __( 'Restrictions', 'ninja-forms' );
		$this->settings_sections['advanced'] = __( 'Advanced', 'ninja-forms' );

		$display = apply_filters( 'nf_display_field_settings', array(
			'label' 			=> array(
				'id'			=> 'label',
				'type'			=> 'text',
				'name' 			=> __( 'Label', 'ninja-forms' ),
				'desc' 			=> '',
				'help_text'		=> '',
				'std' 			=> ''
			),
			'label_pos'			=> array(
				'id'			=> 'label_pos',
				'type'			=> 'select',
				'name'			=> __( 'Label Position', 'ninja-forms' ),
				'desc'			=> '',
				'help_text'		=> '',
				'std'			=> '',
				'options'		=> array(
					array( 'name' => __( 'Above Element', 'ninja-forms' ), 'value' => 'above' ),
					array( 'name' => __( 'Left of Element', 'ninja-forms' ), 'value' => 'left' ),
					array( 'name' => __( 'Inside of Element', 'ninja-forms' ), 'value' => 'inside' ),
					array( 'name' => __( 'Right of Element', 'ninja-forms' ), 'value' => 'right' ),
					array( 'name' => __( 'Below Element', 'ninja-forms' ), 'value' => 'below' ),
				),
			),
			'default_value' 	=> array(
				'id' 			=> 'default_value',
				'type' 			=> 'text',
				'name' 			=> __( 'Default Value', 'ninja-forms' ),
				'desc' 			=> '',
				'help_text' 	=> '',
				'std' 			=> '',
			),
			'wrap_class'		=> array(
				'id' 			=> 'wrap_class',
				'type' 			=> 'text',
				'name' 			=> __( 'Custom Wrapper Classes', 'ninja-forms' ),
				'desc' 			=> __( 'Comma separated list', 'ninja-forms' ),
				'help_text' 	=> '',
				'std' 			=> '',
			),			
			'label_class'		=> array(
				'id' 			=> 'label_class',
				'type' 			=> 'text',
				'name' 			=> __( 'Custom Label Classes', 'ninja-forms' ),
				'desc' 			=> __( 'Comma separated list', 'ninja-forms' ),
				'help_text' 	=> '',
				'std' 			=> '',
			),
			'element_class'		=> array(
				'id' 			=> 'element_class',
				'type' 			=> 'text',
				'name' 			=> __( 'Custom Element Classes', 'ninja-forms' ),
				'desc' 			=> __( 'Comma separated list', 'ninja-forms' ),
				'help_text' 	=> '',
				'std' 			=> '',
			),
		));

		$this->registered_settings['display'] = $display;

		// Register our default field settings
		$restrictions = apply_filters( 'nf_restriction_field_settings', array(
			'req' 				=> array(
				'id' 			=> 'req',
				'type' 			=> 'checkbox',
				'name' 			=> __( 'Required Field', 'ninja-forms' ),
				'desc' 			=> '',
				'help_text' 	=> '',
				'std' 			=> 0,
			),
		) );

		$this->registered_settings['restrictions'] = $restrictions;

		// Register our default field settings
		$advanced = apply_filters( 'nf_restriction_field_settings', array(
			'key' 				=> array(
				'id' 			=> 'key',
				'type' 			=> 'text',
				'name' 			=> __( 'Key Name', 'ninja-forms' ),
				'desc' 			=> '',
				'help_text' 	=> '',
				'std' 			=> '',
			),
			'data_attributes'	=> array(
				'id'			=> 'data_attributes',
				'type'			=> 'textarea',
				'name' 			=> __( 'Data Attributes', 'ninja-forms' ),
				'desc'			=> __( 'Comma separated data attributes like: test="test", test-data="data"', 'ninja-forms' ),
				'help_text'		=> '',
				'std'			=> '',
			),
		) );

		$this->registered_settings['advanced'] = $advanced;


		do_action( 'nf_field_construct', $this );
	}

	/**
	 * Function that renders our field.
	 * This function handles all of the label stuff, and uses the render_element() function that should be present
	 * in the instantiated child.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render() {

		if ( $this->div_wrapper ) {
			echo '<div>';
		}
		if ( $this->settings['label_pos'] != 'none' && $this->settings['label_pos'] != 'inside' ) {
			echo '<label>';
			if ( $this->settings['label_pos'] == 'above' || $this->settings['label_pos'] == 'left' ) {
				echo $this->settings['label'];
			}			
		}

		$this->render_element();

		if ( $this->settings['label_pos'] != 'none' && $this->settings['label_pos'] != 'inside' ) {
			if ( $this->settings['label_pos'] == 'right' || $this->settings['label_pos'] == 'below' ) {
				echo $this->settings['label'];
			}
			echo '</label>';			
		}

		if ( Ninja_Forms()->field( $this->field_id )->get_errors() ) {
			echo '<div class="nf-errors">';
			foreach ( Ninja_Forms()->field( $this->field_id )->get_errors() as $key => $error ) {
				echo '<div>' . $error . '</div>';
			}
			echo '</div>';
		}

		if ( $this->div_wrapper ) {
			echo '</div>';
		}
	}

	/**
	 * This function should be overwritten by child classes
	 *  
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		// This line left intentionally blank.
	}

	/**
	 * Set our current field id.
	 * 
	 * @access public
	 * @param int $field_id
	 * @since 3.0
	 * @return void
	 */
	public function set_field( $field_id ) {
		$this->field_id = $field_id;
		$this->element_id = 'nf_field_' . $field_id;
		foreach( Ninja_Forms()->field_var->settings[ $field_id ] as $setting => $value ) {
			if ( ! empty( $setting ) ) {
				$this->settings[ $setting ] = $value;
			}	
		}

		$this->value = Ninja_Forms()->field_var->values[ $field_id ];
		$this->setup();
	}

	/**
	 * Setup our class for use.
	 * This function should be overwritten by child classes that need specific
	 * setup for each field id.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function setup() {
		// This line left intentionally blank.
	}

	/**
	 * Function that validates our field input if it is set to required.
	 * 
	 * @access public
	 * @since 3.0
	 * @return bool $return
	 */
	public function req_validation() {
		if ( $this->value === '' ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Function that validates our field.
	 * Should be overwritten in child classes.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function validate() {
		// This line left intentionally blank.
	}

	/**
	 * Function that outputs a disabled element for the field list.
	 * Should be overwritten in child classes.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		// This line left intentionally blank.
	}

}
