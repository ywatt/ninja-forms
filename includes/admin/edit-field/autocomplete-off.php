<?php
add_action('init', 'nf_register_edit_autocomplete_off');
function nf_register_edit_autocomplete_off(){
	add_action('ninja_forms_edit_field_after_registered', 'nf_field_autocomplete_off', 10, 2 );
}

function nf_field_autocomplete_off( $field_id, $field_data ) {
	global $ninja_forms_fields;

	$field_type = $field_row['type'];
	$reg_field = $ninja_forms_fields[$field_type];
	$edit_autocomplete_off = $reg_field['edit_autocomplete_off'];
	if( $edit_autocomplete_off ) {
		$autocomplete_off = isset ( $field_data['autocomplete_off'] ) ? $field_data['autocomplete_off'] : 0;
		ninja_forms_edit_field_el_output($field_id, 'checkbox', __( 'Disable Browser Autocomplete', 'ninja-forms' ), 'autocomplete_off', $autocomplete_off, 'thin' );
	}
}