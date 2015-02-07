<?php

function ninja_forms_register_tab_field_settings(){
	if(isset($_REQUEST['form_id'])){
		$form_id = absint( $_REQUEST['form_id'] );
	}else{
		$form_id = '';
	}

	$args = array(
		'name' => __( 'Build Your Form', 'ninja-forms' ),
		'page' => 'ninja-forms',
		'display_function' => 'ninja_forms_tab_field_settings',
		'disable_no_form_id' => true,
		'show_save' => false,
		'tab_reload' => false,
	);
	ninja_forms_register_tab( 'builder', $args );
}

add_action('admin_init', 'ninja_forms_register_tab_field_settings');

function ninja_forms_tab_field_settings(){
	global $wpdb;

	if ( isset ( $_REQUEST['form_id'] ) ) {
		$form_id = absint( $_REQUEST['form_id'] );
	} else {
		$form_id = '';
	}

	if ( ! empty ( $form_id ) && 'new' != $form_id ) {
		do_action( 'ninja_forms_edit_field_before_ul', $form_id );
		do_action( 'ninja_forms_edit_field_ul', $form_id );
		do_action( 'ninja_forms_edit_field_after_ul', $form_id );
	}
}

/**
 * Listen for a new form action and create one if necessary.
 * 
 * @since 2.9
 * @return void
 */
function nf_create_form_listen() {
	$page = isset ( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';
	$tab = isset ( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : '';
	$form_id = isset ( $_REQUEST['form_id'] ) ? $_REQUEST['form_id'] : '';

	if ( 'ninja-forms' == $page && 'builder' == $tab && 'new' == $form_id ) {
		$form_id = Ninja_Forms()->form()->create();
		var_dump ( $form_id );
		$redirect = add_query_arg( array( 'form_id' => $form_id ) );
		var_dump( $redirect );
		wp_redirect( $redirect );
		die();		
	}
}

add_action( 'admin_init', 'nf_create_form_listen', 5 );