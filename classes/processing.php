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
	 * Get things started. Add our processing listener.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		// Check to see if we have a submitted form
		add_action( 'init', array( $this, 'processing_check' ) );		
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

		$this->setup_vars();
		do_action( 'nf_setup_vars' );

		$this->pre_process();

		$this->process();

		$this->post_process();
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
				// Check to see if this is a required field. If it is, run it through our validation function.
				if ( Ninja_Forms()->field( $field_id )->get_setting( 'required' ) == 1 ) {
					$this->validate_field( $field_id );
				}
			}
		}
	}

	/**
	 * Validate submitted fields.
	 * Checks for required fields and ensures that they are completed
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function validate_field( $field_id ) {
		if ( ! Ninja_Forms()->field( $field_id )->validate() ) {
			Ninja_Forms()->field( $field_id )->add_error( 'required', __( 'This is a required field', 'ninja-forms' ) );
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
		do_action( 'nf_post_process' );
	}
}
