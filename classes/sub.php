<?php
/**
 * Submission.
 * This class handles storing, retrieving, editing a submission.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Submissions
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Sub {

	/**
	 * @var $sub_id store our sub id
	 */
	var $sub_id;

	/**
	 * @var $form_id store our form_id
	 */
	var $form_id;

	/**
	 * @var $fields store our user values
	 */
	var $fields;

	/**
	 * @var $action store the action that created this sub
	 */
	var $action;

	/**
	 * @var $user_id store the user ID for this submission
	 */
	var $user_id;

	/**
	 * @var $meta store our non-field meta
	 */
	var $meta;

	/**
	 * @var $date_submitted store our submitted date
	 */
	var $date_submitted;

	/**
	 * @var $date_modified store our modified date
	 */
	var $date_modified;

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 2.7
	 * @return void/
	 */
	public function __construct( $sub_id ) {
		global $ninja_forms_fields;
		// Set our sub id
		$this->sub_id = $sub_id;

		// Setup our form id var
		$this->form_id = get_post_meta( $sub_id, '_form_id', true );
		// Setup our action var
		$this->action = get_post_meta( $sub_id, '_action', true );		
		// Setup our user_id var
		$this->user_id = get_post_meta( $sub_id, '_user_id', true );

		// Setup our fields and meta vars.
		$post_meta = get_post_custom( $this->sub_id );
		$this->fields = array();
		foreach ( $post_meta as $key => $array ) {
			if ( is_serialized( $array[0] ) ) {
				$meta_value = unserialize( $array[0] );
			} else {
				$meta_value = $array[0];
			}

			if ( strpos( $key, '_field_' ) !== false ) {
				$field_id = str_replace( '_field_', '', $key );
				$field = ninja_forms_get_field_by_id( $field_id );
				$field_type = $field['type'];

				// Check to see if our field type has been set as a "process_field".
				if ( isset ( $ninja_forms_fields[ $field_type ] ) ) {
					$reg_field = $ninja_forms_fields[ $field_type ];
					$process_field = $reg_field['process_field'];
				} else {
					$process_field = false;
				}
				if ( $process_field ) {
					$this->fields[ $field_id ] = $meta_value;					
				}

			} else if ( $key != '_form_id' && $key != '_action' && $key != '_user_id' ) {
				$this->meta[ $key ] = $meta_value;
			}
		}
	}

	/**
	 * Update our form id
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function update_form_id( $form_id ) {
		if ( update_post_meta( $this->sub_id, '_form_id', $form_id ) ) {
			$this->form_id = $form_id;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update our action
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function update_action( $action ) {
		if ( update_post_meta( $this->sub_id, '_action', $action ) ) {
			$this->action = $action;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update our user id
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function update_user_id( $user_id ) {
		if ( update_post_meta( $this->sub_id, '_user_id', $user_id ) ) {
			$this->user_id = $user_id;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Add a meta value to our submission.
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function add_meta( $meta_key, $value ) {
		if ( update_post_meta( $this->sub_id, $meta_key, $value ) ) {
			$this->meta[ $meta_key ] = $value;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update a meta value.
	 * Wrapper for add_field().
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function update_meta( $meta_key, $value ) {
		return $this->add_meta( $meta_key, $value );
	}	

	/**
	 * Add a field value to our submission.
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function add_field( $field_id, $value ) {
		$meta_key = '_field_' . $field_id;
		if ( update_post_meta( $this->sub_id, $meta_key, $value ) ) {
			$this->field[ $field_id ] = $value;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update a field value
	 * 
	 * @access public
	 * @since 2.7
	 * @return bool
	 */
	public function update_field( $field_id, $value ) {
		return $this->add_field( $field_id, $value );
	}

	/**
	 * Get a meta value from our submission by meta key
	 * 
	 * @access public
	 * @since 2.7
	 * @return array|bool
	 */
	public function get_meta( $meta_key ) {
		if ( isset ( $this->meta[ $meta_key ] ) ) {
			return $this->meta[ $meta_key ];
		} else {
			return false;
		}
	}

	/**
	 * Get a field value from our submission by field id
	 * 
	 * @access public
	 * @since 2.7
	 * @return array|bool
	 */
	public function get_field( $field_id ) {
		if ( isset ( $this->fields[ $field_id ] ) ) {
			return $this->fields[ $field_id ];
		} else {
			return false;
		}
	}

	/**
	 * Get a submission from the database, returning all the field data.
	 * 
	 * @access public
	 * @since 2.7
	 * @return array $sub
	 */
	public function get_all_fields() {
		return $this->fields;		
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
		$seq_id = $this->get_meta( '_seq_id' );

		$prefix = Ninja_Forms()->form( $this->form_id )->get_setting( 'sub_prefix' );
		$postfix = Ninja_Forms()->form( $this->form_id )->get_setting( 'sub_postfix' );

		return $prefix . $seq_id . $postfix;
		
	}

	/**
	 * Export our current submission.
	 * 
	 * @access public
	 * @param array $sub_ids
	 * @param bool @return
	 * @since 2.7
	 * @return void
	 */
	public function export( $return = false ){
		$sub_ids = array( $this->sub_id );
		Ninja_Forms()->subs()->export( $sub_ids );
	}

}