<?php

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

add_filter( 'nf_subs_csv_field_label', 'nf_old_subs_csv_label' );

// Hook into our new submissions CSV label array filter.
function nf_old_subs_csv_label_array( $label_array ) {
	return apply_filters( 'ninja_forms_export_subs_label_array', $label_array, false );
}

add_filter( 'nf_subs_csv_label_array', 'nf_old_subs_csv_label_array' );

// Hook into our new submissions CSV pre_value filter.
function nf_old_subs_csv_pre_value( $user_value, $field_id ) {
	return apply_filters( 'ninja_forms_export_sub_pre_value', $user_value, $field_id );
}

add_filter( 'nf_subs_export_pre_value', 'nf_old_subs_csv_pre_value' );

// Hook into our new submissions CSV value filter.
function nf_old_subs_csv_value( $user_value, $field_id ) {
	return apply_filters( 'ninja_forms_export_sub_value', $user_value, $field_id );
}

add_filter( 'nf_subs_csv_field_value', 'nf_old_subs_csv_value' );

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
function nf_old_subs_csv_delimiter( $bom ) {
	return apply_filters( 'ninja_forms_csv_delimiter', $bom );
}

add_filter( 'nf_sub_csv_delimiter', 'nf_old_subs_csv_delimiter' );

// Hook into our new CSV enclosure filter
function nf_old_subs_csv_enclosure( $bom ) {
	return apply_filters( 'ninja_forms_csv_enclosure', $bom );
}

add_filter( 'nf_sub_csv_enclosure', 'nf_old_subs_csv_enclosure' );

// Hook into our new CSV terminator filter
function nf_old_subs_csv_terminator( $bom ) {
	return apply_filters( 'ninja_forms_csv_terminator', $bom );
}

add_filter( 'nf_sub_csv_terminator', 'nf_old_subs_csv_terminator' );