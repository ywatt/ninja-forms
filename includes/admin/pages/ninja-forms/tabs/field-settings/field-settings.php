<?php

function ninja_forms_register_tab_field_settings(){
	if(isset($_REQUEST['form_id'])){
		$form_id = absint( $_REQUEST['form_id'] );
	}else{
		$form_id = '';
	}

	$args = array(
		'name' => __( 'Builder', 'ninja-forms' ),
		'page' => 'ninja-forms',
		'display_function' => 'ninja_forms_tab_field_settings',
		'disable_no_form_id' => true,
		'show_save' => false,
		'tab_reload' => false,
	);
	ninja_forms_register_tab('fields', $args);
}

add_action('admin_init', 'ninja_forms_register_tab_field_settings');

function ninja_forms_tab_field_settings(){
	global $wpdb;
	if(isset($_REQUEST['form_id'])){
		$form_id = absint( $_REQUEST['form_id'] );
	}else{
		$form_id = '';
	}
	if($form_id != ''){
		do_action( 'ninja_forms_edit_field_before_ul', $form_id );
		do_action( 'ninja_forms_edit_field_ul', $form_id );
		do_action( 'ninja_forms_edit_field_after_ul', $form_id );
	}
}