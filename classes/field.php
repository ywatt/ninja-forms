<?php
/**
 * Handles the output of fields and interacting with them.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Form
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Field {
	
	/**
	 * @var field_id
	 * @since 3.0
	 */
	var $field_id;	

	/**
	 * @var field_type
	 * @since 3.0
	 */
	var $field_type;

	/**
	 * @var value
	 * @since 3.0
	 */
	var $value = array();

	/**
	 * @var settings
	 * @since 3.0
	 */
	var $settings = array();

	/**
	 * @var settings
	 * @since 3.0
	 */
	var $errors = array();

	/**
	 * Get things running.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Set our current field id and grab the field settings from the database if they don't already exist.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function set_field( $field_id ) {
		$this->field_id = $field_id;
		// Check to see if we've already grabbed this field data from the database.
		if ( ! isset ( $this->settings[ $field_id ] ) ) {
			// Get all of our field settings and set our class variables.
			$this->settings[ $field_id ] = nf_get_object_meta( $field_id );
		}

		// Check to see if we've already setup this field's default value.
		if ( ! isset ( $this->values[ $field_id ] ) ) {
			if ( isset ( $this->settings[ $field_id ]['default_value'] ) ) {
				$value = $this->settings[ $field_id ]['default_value'];
			} else {
				$value = false;
			}
			$this->values[ $field_id ] = $value;
		}
		
		$this->field_type = $this->settings[ $field_id ]['type'];
		$field_type = $this->field_type;
		// Now that we have our field settings, let's set our field_type field id.
		// This means that when we call the render() function later, it knows which field_id to use when rendering.
		Ninja_Forms()->field_types->$field_type->set_field( $field_id );
	}

	/**
	 * Render our field.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render() {
		$field_type = $this->field_type;
		// Call our field_type render() function. We've already told it which field_id we want to render with.
		Ninja_Forms()->field_types->$field_type->render();
	}

	/**
	 * Get one of our field settings.
	 * 
	 * @access public
	 * @since 3.0
	 * @return string $setting
	 */
	public function get_setting( $setting ) {
		if ( isset ( $this->settings[ $this->field_id ][ $setting ] ) ) {
			return $this->settings[ $this->field_id ][ $setting ];
		} else {
			return false;
		}
	}

	/**
	 * Get all of our field settings
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $settings;
	 */
	public function get_settings() {
		if ( isset ( $this->settings[ $this->field_id ] ) ) {
			return $this->settings[ $this->field_id ];
		} else {
			return false;
		}
	}

	/**
	 * Update a field setting (this doesn't update anything in the database)
	 * Changes are only applied to this object.
	 * 
	 * @access public
	 * @param string $setting
	 * @param mixed $value
	 * @since 3.0
	 * @return bool
	 */
	public function update_setting( $setting, $value ) {
		if ( isset ( $this->settings[ $this->field_id ][ $setting ] ) ) {
			$this->settings[ $this->field_id ][ $setting ] = $value;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get field value
	 * 
	 * @access public
	 * @since 3.0
	 * @return mixed $value
	 */
	public function get_value() {
		if ( isset ( $this->values[ $this->field_id ] ) ) {
			return $this->values[ $this->field_id ];
		} else {
			return false;
		}
	}

	/**
	 * Update a field value
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function update_value( $value) {
		$this->values[ $this->field_id ] = $value;
	}

	/**
	 * Add an error to this field
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_error( $key, $error ) {
		$this->errors[ $this->field_id ][ $key ] = $error;
	}

	/**
	 * Get errors attached to this field
	 * 
	 * @access public
	 * @since 3.0
	 * @return mixed $errors or bool(false)
	 */
	public function get_errors() {
		if ( isset ( $this->errors[ $this->field_id ] ) ) {
			return $this->errors[ $this->field_id ];
		} else {
			return false;
		}
	}

	/**
	 * Validate the field
	 * 
	 * @access public
	 * @since 3.0
	 * @return bool
	 */
	public function validate() {
		$field_type = $this->field_type;
		return Ninja_Forms()->field_types->$field_type->validate();
	}

}
