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
	 * @since 2.7
	 */
	var $form_id;

	/**
	 * @var settings - Form Settings
	 * @since 2.7
	 */
	var $settings = array();

	/**
	 * @var fields - Form Fields
	 * @since 2.7
	 */
	var $fields = array();

	/**
	 * @var fields - Fields List
	 * @since 2.7
	 */
	var $field_keys = array();

	/**
	 * @var errors - Form errors
	 * @since 2.7
	 */
	var $errors = array();

	/**
	 * @var subs - Form Submissions
	 * @since 2.7
	 */
	var $subs = array();

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 2.7
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Render our form
	 * 
	 * @access public
	 * @since 2.7
	 * @return void
	 */
	public function render() {
		echo '<h2>' . $this->settings[ $this->form_id ]['name'] . '</h2>';
		echo '<form id="nf_form_' . $this->form_id . '" action="" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="form_id" value="' . $this->form_id . '" />';
		echo '<input type="hidden" name="nf_submitted" value="1" />';
		wp_nonce_field( 'nf_submit', 'nf_form_' . $this->form_id );
		// Get the fields attached to this form.
		$all_fields = $this->fields[ $this->form_id ];
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
	 * @since 2.7
	 * @return void
	 */
	public function set_form( $form_id ) {
		// Set our current form id.
		$this->form_id = $form_id;

		/*
		// Check to see if we've already gotten our settings from the database.
		if ( ! isset ( $this->settings[ $form_id ] ) ) {
			// Get our form settings from the database.
			$this->settings[ $form_id ] = nf_get_form_settings( $form_id );
		}
		//Check to see if we've already gotten our fields from the database.
		if ( ! isset ( $this->fields[ $form_id ] ) ) {
			// Get an of all of our fields.
			$this->fields[ $form_id ] = nf_get_fields_by_form_id( $this->form_id, false );

			if ( is_array( $this->fields[ $form_id ] ) ) {
				foreach ( $this->fields[ $form_id ] as $field ) {
					$key = nf_get_object_meta_value( $field, 'key' );
					if ( $key ) {
						$this->field_keys[ $this->form_id ][ $key ] = $field;
					}
				}
			}
		}
		*/
	}

	/**
	 * Get one of our form settings.
	 * 
	 * @access public
	 * @since 2.7
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
	 * @since 2.7
	 * @return array $settings;
	 */
	public function get_settings() {
		if ( isset ( $this->settings[ $this->form_id ] ) ) {
			return $this->settings[ $this->form_id ];
		} else {
			return false;
		}
	}

	public function get_fields() {
		if ( isset ( $this->fields[ $this->form_id ] ) ) {
			return $this->fields[ $this->form_id ];
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
	 * Function that allows the user to interact with a field by its key name or id
	 * 
	 * @access public
	 * @since 2.7
	 * @return object
	 */
	public function field( $key ) {
		if ( isset ( Ninja_Forms()->field_var->settings[ $key ] ) ) {
			return Ninja_Forms()->field( $key );
		} else if ( isset ( $this->field_keys[ $this->form_id ][ $key ] ) ) {
			return Ninja_Forms()->field( $this->field_keys[ $this->form_id ][ $key ] );
		} else {
			return false;
		}
	}

	/**
	 * Get all the submissions for this form
	 * 
	 * @access public
	 * @since 2.7
	 * @return array $subs
	 */
	public function get_subs() {
		$args = array(
			'post_type' => 'nf_sub',
			'meta_key' => '_form_id',
			'meta_value' => $this->form_id,
		);
		$query = new WP_Query( $args );
		echo "<pre>";
		print_r( $query );
		echo "</pre>";
	}

}