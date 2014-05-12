<?php
/**
 * Handles the processing of a submitted form.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Processing
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Processing {

	/**
	 * @var form_id - Keep track of the form we are processing.
	 * @since 3.0
	 */
	var $form_id;

	/**
	 * @var sub_id - Keep track of the submission for this processing.
	 * @since 3.0
	 */
	var $sub_id;

	/**
	 * Get things started. Add our processing listener.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		// Check to see if we have a submitted form
		add_action( 'init', array( $this, 'processing_check' ), 11 );		
	}

	/**
	 * Our processing listener.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function processing_check() {
		// Bail if we don't have a submitted var
		if ( ! isset ( $_POST['nf_submitted'] ) || $_POST['nf_submitted'] != 1)
			return false;

		// Bail if we don't have a submitted form id
		if ( ! isset ( $_POST['form_id'] ) )
			return false;

		$form_id = $_POST['form_id'];

		// Bail if we don't have a nonce set.
		if ( ! isset ( $_POST['nf_form_' . $form_id ] ) )
			return false;

		// Bail if our nonce doesn't verify
		if ( ! wp_verify_nonce( $_POST['nf_form_' . $form_id ], 'nf_submit' ) )
			return false;

		// Setup our form
		Ninja_Forms()->form( $form_id );

		$this->setup_vars();

		$errors = $this->get_errors();
		if ( empty ( $errors ) ) {
			$this->pre_process();
		}
	
		$errors = $this->get_errors();
		if ( empty ( $errors ) ) {
			$this->process();
		}

		$errors = $this->get_errors();
		if ( empty ( $errors ) ) {
			$this->post_process();
		}

	}

	/**
	 * Setup field values from the submitted form.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function setup_vars() {
		// Set our current form id
		$this->form_id = $_POST['form_id'];
		
		// Loop through our submitted fields and get the values.
		foreach ( $_POST as $key => $val ) {
			if ( strpos ( $key, 'nf_field_' ) !== false ) {
				$field_id = str_replace( 'nf_field_', '', $key );
				// Update our fields with the new values.
				Ninja_Forms()->field( $field_id )->update_value( $val );
			}
		}

		do_action( 'nf_setup_vars' );
	}

	/**
	 * Create our submission
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function create_sub() {
		$this->sub_id = Ninja_Forms()->sub()->create_sub();
		Ninja_Forms()->sub( $this->sub_id )->add_value( 'form_id', $this->form_id );
	}
	
	/**
	 * Add our submission values
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_sub_values() {
		foreach( Ninja_Forms()->form( $this->form_id )->get_fields() as $field_id ) {
			if ( apply_filters( 'nf_add_sub_value', Ninja_Forms()->field( $field_id )->type->add_to_sub ) ) {
				$val = Ninja_Forms()->field( $field_id )->get_value();
				Ninja_Forms()->sub( $this->sub_id )->add_value( $field_id, $val );				
			}
		}
	}

	/**
	 * Begin form processing
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function pre_process() {
		foreach( Ninja_Forms()->form( $this->form_id )->get_fields() as $field_id ) {
			
			// Check to see if this is a required field. If it is, run it through our validation function.
			if ( Ninja_Forms()->field( $field_id )->get_setting( 'required' ) == 1 && ! Ninja_Forms()->field( $field_id )->req_validation() ) {
				// This field didn't pass required validation. Add an error to it.
				Ninja_Forms()->field( $field_id )->add_error( 'required', __( 'This is a required field', 'ninja-forms' ) );
			}
			/**
			 * Run our field validation. There is no default validation for a field.
			 * This is designed to be overwritten by child field classes, such as password fields,
			 * that need to ensure input is valid.
			 */
			Ninja_Forms()->field( $field_id )->validate();
			
		}
		do_action( 'nf_pre_process' );
	}

	/**
	 * Main form processing
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function process() {
		do_action( 'nf_process' );
	}

	/**
	 * Post processing
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function post_process() {
		// Submission creation
		if ( apply_filters( 'nf_save_submission', true ) ) {
			// Create our submission
			$this->create_sub();
			// Add our submitted values to the submission.
			$this->add_sub_values();		
		}

		do_action( 'nf_post_process' );
	}

	/**
	 * Provides interaction for the form currently being processed.
	 * It can be accessed using: Ninja_Forms()->processing->form()->methods
	 * 
	 * @access public
	 * @since 3.0
	 * @return object
	 */
	public function form() {
		if ( $this->form_id ) {
			return Ninja_Forms()->form( $this->form_id );
		} else {
			return false;
		}
	}

	/**
	 * Provides interaction for fields currently being processed.
	 * It can be accessed using: Ninja_Forms()->processing->field( id/key )->methods
	 * 
	 * @access public
	 * @since 3.0
	 * @return object
	 */
	public function field( $key = '' ) {
		if ( isset ( Ninja_Forms()->field_var->settings[ $key ] ) ) {
			return Ninja_Forms()->form( $this->form_id )->field( $key );
		} else {
			return Ninja_Forms()->field( $key );
		}
	}

	/**
	 * Return a list of the fields currently being processed
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $fields
	 */
	public function get_fields() {
		return Ninja_Forms()->form( $this->form_id )->get_setting( 'fields' );
	}

	/**
	 * Return any errors that have been added to the form or fields
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $errors
	 */
	public function get_errors() {
		$errors = array();

		$field_errors = Ninja_Forms()->field_var->errors;
		$form_errors = $this->form()->errors;

		if ( ! empty ( $field_errors ) ) {
			$errors['field'] = $field_errors;
		}

		if ( ! empty ( $form_errors ) ) {
			$errors['form'] = $form_errors;
		}

		return $errors;
	}
}
