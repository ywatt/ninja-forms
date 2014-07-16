<?php
/**
 * Submissions.
 * This class handles creating and exporting submissions.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Submissions
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Subs {

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 2.7
	 * @return void/
	 */
	public function __construct() {
		// Start our custom post type class
		$this->CPT = new NF_Subs_CPT();
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

		// Add our form ID to the submission
		Ninja_Forms()->sub( $sub_id )->update_form_id( $form_id );

		// Get the current sequential ID
		$form = ninja_forms_get_form_by_id( $form_id );
		if ( isset ( $form['data']['last_sub'] ) ) {
			$seq_id = $form['data']['last_sub'] + 1;
		} else { // If we don't have a starting number, start at 1
			$seq_id = 1;
		}

		$seq_id = apply_filters( 'nf_sub_seq_id', $seq_id, $form_id );

		// Add the sequential ID to the post meta
		Ninja_Forms()->sub( $sub_id )->update_meta( '_seq_id', $seq_id );

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

		// Update our sub count
		Ninja_Forms()->form( $form_id )->sub_count = $seq_id - 1;

		return $sub_id;
	}

	/**
	 * Get submissions based on specific critera.
	 * 
	 * @since 2.7
	 * @param array $args
	 * @return array $sub_ids
	 */
	public function get( $args = array() ) {

		$date_query = array();

		$plugin_settings = nf_get_settings();

		if ( isset ( $plugin_settings['date_format'] ) ) {
			$date_format = $plugin_settings['date_format'];
		} else {
			$date_format = 'm/d/Y';
		}

		if( isset( $args['form_id'] ) ) {
			$meta_query[] = array(
				'key' => '_form_id',
				'value' => $args['form_id'],
			);
		}

		if( isset( $args['user_id'] ) ) {
			$meta_query[] = array(
				'key' => '_user_id',
				'value' => $args['user_id'],
			);
		}

		if( isset( $args['action'])){
			$meta_query[] = array(
				'key' => '_action',
				'value' => $args['action'],
			);
		}

		if ( isset ( $args['meta'] ) ) {
			foreach ( $meta as $key => $value ) {
				$meta_query[] = array(
					'key' => $key,
					'value' => $value,
				);
			}
		}

		if( isset( $args['begin_date'] ) AND $args['begin_date'] != '') {
			$begin_date = $args['begin_date'];
			if ( $date_format == 'd/m/Y' ) {
				$begin_date = str_replace( '/', '-', $begin_date );
			} else if ( $date_format == 'm-d-Y' ) {
				$begin_date = str_replace( '-', '/', $begin_date );
			}
			$begin_date .= '00:00:00';
			$begin_date = new DateTime( $begin_date );
			$begin_date = $begin_date->format("Y-m-d G:i:s");

			$date_query['after'] = $begin_date;
		}

		if( isset( $args['end_date'] ) AND $args['end_date'] != '' ) {
			$end_date = $args['end_date'];
 			if ( $date_format == 'd/m/Y' ) {
				$end_date = str_replace( '/', '-', $end_date );
			} else if ( $date_format == 'm-d-Y' ) {
				$end_date = str_replace( '-', '/', $end_date );
			}
			$end_date .= '23:59:59';
			$end_date = new DateTime( $end_date );
			$end_date = $end_date->format("Y-m-d G:i:s");

			$date_query['before'] = $end_date;
		}

		$date_query['inclusive'] = true;

		$query_args = array(
			'post_type' 		=> 'nf_sub',
			'date_query' 		=> $date_query,
			'meta_query' 		=> $meta_query,
			'posts_per_page'	=> -1,
		);

		$subs = new WP_Query( $query_args );;

		$sub_objects = array();

		if ( is_array( $subs->posts ) && ! empty( $subs->posts ) ) {
			foreach ( $subs->posts as $sub ) {
				$sub_objects[] = Ninja_Forms()->sub( $sub->ID );
			}			
		}

		wp_reset_postdata();
		return $sub_objects;
	}

	/**
	 * Export submissions.
	 * 
	 * @access public
	 * @param array $sub_ids
	 * @param bool @return
	 * @since 2.7
	 * @return void
	 */
	public function export( $sub_ids = '', $return = false ){
		global $ninja_forms_fields;

		// Bail if we haven't been sent any IDs.
		if ( empty( $sub_ids ) )
			return false;

		$plugin_settings = nf_get_settings();
		$date_format = $plugin_settings['date_format'];
	
		$label_array = array();
		// Get our Form ID.
		$form_id = Ninja_Forms()->sub( $sub_ids[0] )->form_id;
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
					$user_value = Ninja_Forms()->sub( $sub_id )->get_field( $field_id );
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