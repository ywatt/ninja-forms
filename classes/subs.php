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
	public function get_all_fields() {
		global $ninja_forms_fields;
		$post_meta = get_post_custom( $this->sub_id );
		$fields = array();
		foreach ( $post_meta as $key => $array ) {
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
					if ( is_serialized( $array[0] ) ) {
						$user_value = unserialize( $array[0] );
					} else {
						$user_value = $array[0];
					}
					$fields[ $field_id ] = $user_value;					
				}
			}
		}
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

	/**
	 * Export our current submission.
	 * 
	 * @access public
	 * @param array $sub_ids
	 * @param bool @return
	 * @since 2.7
	 * @return void
	 */
	public function export( $sub_ids = '', $return = false ){
		global $ninja_forms_fields;

		$plugin_settings = nf_get_settings();
		$date_format = $plugin_settings['date_format'];
	
		if ( $sub_ids == '' ) { // If we haven't been sent any sub ids, then we'll export using $this->sub_id.
			$sub_ids = array( $this->sub_id );
		}

		// Bail if we haven't been sent any IDs.
		if ( empty( $sub_ids ) )
			return false;

		$label_array = array();
		// Get our Form ID.
		$form_id = get_post_meta( $sub_ids[0], '_form_id', true );
		// Get our list of fields.
		$fields = nf_get_fields_by_form_id( $form_id );
		// Add our "Date" label.
		$label_array[0][] = __( 'Date Submitted', 'ninja-forms' );
		foreach ( $fields as $field_id => $field ) {
			// Get our field type
			$field_type = $field['type'];
			// Check to see if our field type has been set as a "process_field".
			if ( isset ( $ninja_forms_fields[ $field_type ] ) ) {
				$reg_field = $ninja_forms_fields[ $field_type ];
				$process_field = $reg_field['process_field'];
			} else {
				$process_field = false;
			}
			// If this field's "process_field" is set to true, then add its label to the array.
			if ( $process_field ) {
				if ( isset ( $field['data']['admin_label'] ) && $field['data']['admin_label'] != '' ) {
					$label = $field['data']['admin_label'];
				} else if( isset ( $field['data']['label'] ) ) {
					$label = $field['data']['label'];
				}else{
					$label = '';
				}

				$label_array[0][ $field_id ] = apply_filters( 'nf_subs_csv_field_label', $label, $field_id );
			}
		}

		$label_array = ninja_forms_stripslashes_deep( $label_array );
		$label_array = apply_filters( 'nf_subs_csv_label_array', $label_array );

		$value_array = array();

		foreach ( $sub_ids as $sub_id ) {
			$date = get_post_time( 'U', false, $sub_id );
			$value_array[ $sub_id ][] = date( $date_format, $date );
			foreach ( $label_array[0] as $field_id => $label ) {
				if ( $field_id > 0 ) {
					$user_value = Ninja_Forms()->sub( $sub_id )->get_value( $field_id, true );
					$user_value = apply_filters( 'nf_subs_export_pre_value', $user_value, $field_id );
					
					if ( is_array( $user_value ) ) {
						$user_value = implode( ',', $user_value );
					}

					$value_array[ $sub_id ][] = apply_filters( 'nf_subs_csv_field_value', $user_value, $field_id );					
				}
			}
		}

		$value_array = ninja_forms_stripslashes_deep( $value_array );
		$value_array = apply_filters( 'nf_subs_csv_value_array', $value_array );

		$array = array( $label_array, $value_array );
		$today = date( $date_format, current_time( 'timestamp' ) );
		$filename = apply_filters( 'nf_subs_csv_filename', 'nf_subs_' . $today );
		$filename = $filename . ".csv";

		if( $return ){
			return str_putcsv( $array, 
				apply_filters( 'nf_sub_csv_delimiter', ',' ), 
				apply_filters( 'nf_sub_csv_enclosure', '"' ), 
				apply_filters( 'nf_sub_csv_terminator', "\n" )
			);
		}else{
			header( 'Content-type: application/csv');
			header( 'Content-Disposition: attachment; filename="'.$filename .'"' );
			header( 'Pragma: no-cache');
			header( 'Expires: 0' );
			echo apply_filters( 'nf_sub_csv_bom',"\xEF\xBB\xBF" ) ; // Byte Order Mark
			echo str_putcsv( $array, 
				apply_filters( 'nf_sub_csv_delimiter', ',' ), 
				apply_filters( 'nf_sub_csv_enclosure', '"' ), 
				apply_filters( 'nf_sub_csv_terminator', "\n" )
			);

			die();
		}

	}

}