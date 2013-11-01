<?php

/*
 *
 * Function that filters our fields looking for calculations that need to be made upon page load.
 *
 * @since 2.2.28
 * @returns $data
 */

function ninja_forms_field_honeypot_filter( $data, $field_id ){
	global $ninja_forms_processing;

	if( is_object( $ninja_forms_processing ) ){
		$field_row = $ninja_forms_processing->get_field_settings( $field_id );
	}else{
		$field_row = ninja_forms_get_field_by_id( $field_id );
	}

	if ( $field_row['type'] == '_honeypot' ) {

		$data['label_pos'] = 'above';
		$data['label'] = __( 'If you are a human and are seeing this field, please leave it blank.', 'ninja-forms' );
		$data['default_value'] = '';
		$data['visible'] = '0';

	}
	return $data;
}
add_filter( 'ninja_forms_field', 'ninja_forms_field_honeypot_filter', 11, 2 );
