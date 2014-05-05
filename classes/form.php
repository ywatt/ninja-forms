<?php
/**
 * Handles the output of our form, as well as interacting with its settings.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Form
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Form {

	/**
	 * @var form_id
	 * @since 3.0
	 */
	var $form_id;

	/**
	 * @var settings - Form Settings
	 * @since 3.0
	 */
	var $settings = array();

	/**
	 * @var fields - Fields List
	 * @since 3.0
	 */
	var $field_keys = array();

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Render our form
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render() {
		echo '<h2>' . $this->settings[ $this->form_id ]['name'] . '</h2>';
		echo '<form id="" action="" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="form_id" value="' . $this->form_id . '" />';
		echo '<input type="hidden" name="nf_submitted" value="1" />';
		wp_nonce_field( 'nf_submit', 'nf_form_' . $this->form_id );
		// Get the fields attached to this form.
		$all_fields = $this->settings[ $this->form_id ]['fields'];
		if ( is_array( $all_fields ) ) {
			foreach ( $all_fields as $field_id ) {
				// Render our field.
				Ninja_Forms()->field( $field_id )->render();
			}
		}
		echo '</form>';
	}

	/**
	 * Set form id
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function set_form( $form_id ) {
		// Set our current form id.
		$this->form_id = $form_id;
		// Check to see if we've already gotten our settings from the database.
		if ( ! isset ( $this->settings[ $form_id ] ) ) {
			// Get our form settings from the database.
			$this->settings[ $form_id ] = nf_get_object_meta( $form_id );
			// Get an of all of our fields.
			$this->settings[ $form_id ]['fields'] = nf_get_fields_by_form_id( $this->form_id, false );
			if ( is_array( $this->settings[ $form_id ]['fields'] ) ) {
				foreach ( $this->settings[ $form_id ]['fields'] as $field ) {
					$key = nf_get_object_meta_value( $field, 'key' );
					if ( $key ) {
						$this->field_keys[ $this->form_id ][ $key ] = $field;
					}
				}
			}
		}
	}

	/**
	 * Get one of our form settings.
	 * 
	 * @access public
	 * @since 3.0
	 * @return string $setting
	 */
	public function get_setting( $setting ) {
		if ( isset ( $this->settings[ $this->form_id ][ $setting ] ) ) {
			return $this->settings[ $this->form_id ][ $setting ];
		} else {
			return false;
		}
	}

	/**
	 * Get all of our form settings
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $settings;
	 */
	public function get_settings() {
		if ( isset ( $this->settings[ $this->form_id ] ) ) {
			return $this->settings[ $this->form_id ];
		} else {
			return false;
		}
	}

	/**
	 * Update a form setting (this doesn't update anything in the database)
	 * Changes are only applied to this object.
	 * 
	 * @access public
	 * @param string $setting
	 * @param mixed $value
	 * @return bool
	 */
	public function update_setting( $setting, $value ) {
		if ( isset ( $this->settings[ $this->form_id ][ $setting ] ) ) {
			$this->settings[ $this->form_id ][ $setting ] = $value;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Function that allows the user to interact with a field by its key name
	 * 
	 * @access public
	 * @since 3.0
	 * @return object
	 */
	public function field( $key ) {
		if ( isset ( $this->field_keys[ $this->form_id ][ $key ] ) ) {
			return Ninja_Forms()->field( $this->field_keys[ $this->form_id ][ $key ] );
		} else {
			return false;
		}
	}
	
}