<?php

/**
 * Deprecated as of version 2.7.
 */

// Hook into our new save sub filter to add any deprecated filters
function nf_old_save_sub_filter( $user_value, $field_id ) {
	return apply_filters( 'ninja_forms_save_sub', $user_value, $field_id );
}

add_filter( 'nf_save_sub_user_value', 'nf_old_save_sub_filter', 10, 2 );

// Hook into our new nf_save_sub action and add any actions hooked into our old action hooks.
function nf_old_save_sub_action( $sub_id ) {
	do_action( 'ninja_forms_insert_sub', $sub_id );
}

add_action( 'nf_save_sub', 'nf_old_save_sub_action' );

// Hook into our new submissions CSV filename filter.
function nf_old_subs_csv_filename( $filename ) {
	return apply_filters( 'ninja_forms_export_subs_csv_file_name', $filename );
}

add_filter( 'nf_subs_csv_filename', 'nf_old_subs_csv_filename' );

// Hook into our new submissions CSV label filter.
function nf_old_subs_csv_label( $label, $field_id ) {
	return apply_filters( 'ninja_forms_export_sub_label', $label, $field_id );
}

add_filter( 'nf_subs_csv_field_label', 'nf_old_subs_csv_label', 10, 2 );

// Hook into our new submissions CSV label array filter.
function nf_old_subs_csv_label_array( $label_array ) {
	return apply_filters( 'ninja_forms_export_subs_label_array', $label_array, false );
}

add_filter( 'nf_subs_csv_label_array', 'nf_old_subs_csv_label_array' );

// Hook into our new submissions CSV pre_value filter.
function nf_old_subs_csv_pre_value( $user_value, $field_id ) {
	return apply_filters( 'ninja_forms_export_sub_pre_value', $user_value, $field_id );
}

add_filter( 'nf_subs_export_pre_value', 'nf_old_subs_csv_pre_value', 10, 2 );

// Hook into our new submissions CSV value filter.
function nf_old_subs_csv_value( $user_value, $field_id ) {
	return apply_filters( 'ninja_forms_export_sub_value', $user_value, $field_id );
}

add_filter( 'nf_subs_csv_field_value', 'nf_old_subs_csv_value', 10, 2 );

// Hook into our new submissions CSV value array filter.
function nf_old_subs_csv_value_array( $value_array ) {
	return apply_filters( 'ninja_forms_export_subs_label_array', $value_array, false );
}

add_filter( 'nf_subs_csv_value_array', 'nf_old_subs_csv_value_array' );

// Hook into our new CSV BOM filter
function nf_old_subs_csv_bom( $bom ) {
	return apply_filters( 'ninja_forms_csv_bom', $bom );
}

add_filter( 'nf_sub_csv_bom', 'nf_old_subs_csv_bom' );

// Hook into our new CSV delimiter filter
function nf_old_subs_csv_delimiter( $delimiter ) {
	return apply_filters( 'ninja_forms_csv_delimiter', $delimiter );
}

add_filter( 'nf_sub_csv_delimiter', 'nf_old_subs_csv_delimiter' );

// Hook into our new CSV enclosure filter
function nf_old_subs_csv_enclosure( $enclosure ) {
	return apply_filters( 'ninja_forms_csv_enclosure', $enclosure );
}

add_filter( 'nf_sub_csv_enclosure', 'nf_old_subs_csv_enclosure' );

// Hook into our new CSV terminator filter
function nf_old_subs_csv_terminator( $terminator ) {
	return apply_filters( 'ninja_forms_csv_terminator', $terminator );
}

add_filter( 'nf_sub_csv_terminator', 'nf_old_subs_csv_terminator' );

// Hook into our new Submissions table row-actions filter
function nf_old_subs_table_row_actions_filter( $actions, $sub_id, $form_id ) {
	return apply_filters( 'ninja_forms_sub_table_row_actions', array(), false, $sub_id, $form_id );
}

add_filter( 'nf_sub_table_row_actions', 'nf_old_subs_table_row_actions_filter', 10, 3 );

function ninja_forms_get_subs( $args = array() ) {

	$plugin_settings = nf_get_settings();

	if ( isset ( $plugin_settings['date_format'] ) ) {
		$date_format = $plugin_settings['date_format'];
	} else {
		$date_format = 'm/d/Y';
	}

	if( is_array( $args ) AND ! empty( $args ) ) {

		$subs_results = array();
		$meta_query = array();
		$date_query = array();

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

		if( isset( $args['begin_date'] ) AND $args['begin_date'] != '') {
			$begin_date = $args['begin_date'];
			if ( $date_format == 'd/m/Y' ) {
				$begin_date = str_replace( '/', '-', $begin_date );
			} else if ( $date_format == 'm-d-Y' ) {
				$begin_date = str_replace( '-', '/', $begin_date );
			}
			$begin_date = strtotime($begin_date);
			$begin_date = date("Y-m-d 00:00:00", $begin_date);

			$date_query['after'] = $begin_date;
		}

		if( isset( $args['end_date'] ) AND $args['end_date'] != '' ) {
			$end_date = $args['end_date'];
			if ( $date_format == 'd/m/Y' ) {
				$end_date = str_replace( '/', '-', $end_date );
			} else if ( $date_format == 'm-d-Y' ) {
				$end_date = str_replace( '-', '/', $end_date );
			}
			$end_date = strtotime($end_date);
			$end_date = date("Y-m-d 11:59:59", $end_date);

			$date_query['before'] = $end_date;
		}

		$query_args = array(
			'post_type' 	=> 'nf_sub',
			'date_query' 	=> $date_query,
			'meta_query' 	=> $meta_query,
		);

		$subs = get_posts( $query_args );

		if ( is_array( $subs ) && ! empty( $subs ) ) {
			$x = 0;
			foreach ( $subs as $sub ) {
				$data = array();
				$subs_results[$x]['id'] = $sub->ID;
				$subs_results[$x]['user_id'] = $sub->post_author;
				$subs_results[$x]['form_id'] = Ninja_Forms()->sub( $sub->ID )->form_id;
				$subs_results[$x]['action'] = Ninja_Forms()->sub( $sub->ID )->action;

				$fields = Ninja_Forms()->sub( $sub->ID )->get_all_fields();
				foreach ( $fields as $field_id => $user_value ) {
					$data[] = array( 'field_id' => $field_id, 'user_value' => $user_value ); 
				}

				$subs_results[$x]['data'] = $data;

				$x++;
			}
		}

		echo "<pre>";
		print_r( $subs_results );
		echo "</pre>";

		//return $subs_results;
	}
}