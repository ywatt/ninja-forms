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
	var $sidebar = 'general';

	/**
	 * @var settings_menu
	 * @since 3.0
	 */
	var $settings_menu = array();

	/**
	 * @var registered_settings
	 * @since 3.0
	 */
	var $registered_settings = array();

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
	 * @var class
	 * @since 3.0
	 */
	var $class = '';

	/**
	 * @var value
	 * @since 3.0
	 */
	var $value = false;

	/**
	 * @var label
	 * @since 3.0
	 */
	var $label = 'Your Item';

	/**
	 * @var label
	 * @since 3.0
	 */
	var $label_pos = 'left';

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
		if ( $this->label_pos != 'none' && $this->label_pos != 'inside' ) {
			echo '<label>';
			if ( $this->label_pos == 'left' ) {
				echo $this->label;
			}			
		}

		if ( $this->label_pos == 'inside' ) {
			$this->placeholder = $this->label;
		}

		$this->render_element();

		if ( $this->label_pos != 'none' && $this->label_pos != 'inside' ) {
			if ( $this->label_pos == 'right' ) {
				echo $this->label;
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
				$this->$setting = $value;
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
