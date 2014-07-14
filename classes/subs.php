<?php
/**
 * Submissions.
 * This class handles storing, retrieving, editing submissions.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Submissions
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Subs {

	/**
	 * @var sub_id store our current sub id
	 */
	var $sub_id;

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 2.7
	 * @return void/
	 */
	public function __construct() {
		// Include our submission files.
		$this->includes();
		// Start our custom post type class
		$this->CPT = new NF_Subs_CPT();

	}

	/**
	 * Include our submission-related files
	 * 
	 * @access private
	 * @since 2.7
	 * @return void
	 */
	private function includes() {
		// Include our subs CPT
		require_once( NF_PLUGIN_DIR . 'classes/subs-cpt.php' );
	}

	/**
	 * Set our current submission id
	 * 
	 * @access public
	 * @since 2.7
	 * @return void
	 */
	public function set_sub( $sub_id ) {
		$this->sub_id = $sub_id;
	}

	/**
	 * Create a submission.
	 * 
	 * @access public
	 * @since 2.7
	 * @return int $sub_id
	 */
	public function create_sub( $form_id = '' ) {
		// Create Submission
		$post = array(
		  'post_status'    => 'publish',
		  'post_type'      => 'nf_sub'
		);
		$sub_id = wp_insert_post( $post );
		$this->sub_id = $sub_id;

		// Add our form ID to the submission
		$this->add_value( '_form_id', $form_id );

		// Get the current sequential ID
		$form = ninja_forms_get_form_by_id( $form_id );
		if ( isset ( $form['data']['last_sub'] ) ) {
			$seq_id = $form['data']['last_sub'] + 1;
		} else { // If we don't have a starting number, start at 1
			$seq_id = 1;
		}

		$seq_id = apply_filters( 'nf_sub_seq_id', $seq_id, $form_id );

		// Add the sequential ID to the post meta
		update_post_meta ( $this->sub_id, '_seq_id', $seq_id );

		// Update our form data with the new "last seq id."
		$form['data']['last_sub'] = $seq_id;
		$args = array(
			'update_array' => array(
				'data' => serialize( $form['data'] ),
				),
			'where' => array(
				'id' => $form_id,
				),
		);

		ninja_forms_update_form( $args );

		return $sub_id;
	}

	/**
	 * Add a submitted value to our submission.
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function add_value( $meta_key, $value, $field = false ) {
		if ( $field )
			$meta_key = '_field_' . $meta_key;
		if ( update_post_meta( $this->sub_id, $meta_key, $value ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get a submitted value from our submission by field id
	 * 
	 * @access public
	 * @since 2.7
	 * @return mixed
	 */
	public function get_value( $meta_key, $field = false ) {
		if ( $field )
			$meta_key = '_field_' . $meta_key;
		return get_post_meta( $this->sub_id, $meta_key, true );
	}

	/**
	 * Get a submission from the database, returning all the field data.
	 * 
	 * @access public
	 * @since 2.7
	 * @return array $sub
	 */
	public function get_sub( $sub_id ) {
		echo "GET SUB";
	}

	/**
	 * Get a submission sequential ID by the post ID.
	 * This function puts together the prefix, sequential number, and postfix
	 * 
	 * @access public
	 * @since 2.7
	 * @return string $seq_id
	 */
	public function get_seq_id() {
		$seq_id = get_post_meta( $this->sub_id, '_seq_id', true );

		if ( isset ( $this->CPT->form['data']['sub_prefix'] ) && $this->CPT->form['data']['sub_prefix'] != '' ) {
			$prefix = $this->CPT->form['data']['sub_prefix'] . '-';
		} else {
			$prefix = '';
		}

		if ( isset ( $this->CPT->form['data']['sub_postfix'] ) && $this->CPT->form['data']['sub_postfix'] != '' ) {
			$postfix = '-' . $this->CPT->form['data']['sub_postfix'];
		} else {
			$postfix = '';
		}

		return $prefix . $seq_id . $postfix;
		
	}

}