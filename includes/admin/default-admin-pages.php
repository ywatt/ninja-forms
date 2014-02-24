<?php

/**
 * Add our default administration pages.
 * 
 * @since 3.0
 * @return void
 */

function nf_register_default_admin_pages() {
	if ( isset ( $_REQUEST['page'] ) and $_REQUEST['page'] == 'ninja-forms-edit' and isset ( $_REQUEST['form_id'] ) ) {
		$edit_form_parent = 'ninja-forms';
	} else {
		$edit_form_parent = null;
	}

	if ( isset ( $_REQUEST['form_id'] ) ) {
		$form_id = $_REQUEST['form_id'];
	} else {
		$form_id = '';
	}

	$capabilities = apply_filters( 'ninja_forms_admin_menu_capabilities', 'manage_options' );

	$page = add_menu_page( 'Ninja Forms' , __( 'Forms', 'ninja-forms' ), $capabilities, 'ninja-forms', null, NF_PLUGIN_URL.'/images/ninja-head-ico-small.png' );

	// We add these pages using the register_admin_page method, but, because they each have a custom display function, we could have also used
	// the regular WordPress add_submenu_page. The exception is our plugin settings page.
	$args = array(
		'page_title' 	=> __( 'Forms', 'ninja-forms' ),
		'menu_title'	=> __( 'All Forms', 'ninja-forms' ),
		'menu_slug'		=> 'ninja-forms',
		'scope' 		=> 'form',
		'function' 		=> 'nf_admin_all_forms',
		'js'			=> 'nf_admin_all_forms_js',
	);
	Ninja_Forms()->admin_settings_pages->register_admin_page( $args );

	// Add a filter for the all_forms
	add_filter( 'nf_rest_get_array', 'nf_all_forms_rest_filter', 10, 3 );
	add_filter( 'nf_rest_get_array', 'nf_wizard_rest_filter', 10, 3 );

	$args = array(
		'page_title' 	=>	__( 'Add New', 'ninja-forms' ),
		'menu_title'	=> 	__( 'Add New', 'ninja-forms' ),
		'menu_slug'		=>	'ninja-forms&form_id=new',
		'scope' 		=> 	'form',
		'function'		=> 	'nf_admin_all_forms',
	);
	Ninja_Forms()->admin_settings_pages->register_admin_page( $args );

	if ( $form_id != '' ) {
		$parent_slug = 'ninja-forms';
	} else {
		$parent_slug = '';
	}

	$args = array(
		'parent_slug'	=>	$parent_slug,
		'page_title' 	=>	__( 'Edit Form', 'ninja-forms' ),
		'menu_title'	=> 	__( 'Edit Form', 'ninja-forms' ),
		'menu_slug'		=>	'ninja-forms-edit',
		'scope' 		=> 	'form',
		'function'		=> 	'nf_admin_edit_form',
		//'js'			=> 	'nf_admin_edit_form_js',
	);
	Ninja_Forms()->admin_settings_pages->register_admin_page( $args );		

	/*
	 * This is our plugin settings page. It doesn't have a display function because we are using the built-in Ninja Forms backbone handler.
	 * The 'scope' defined here tells Ninja Forms to find all of the groups that are assigned to that scope and display them on this page.
	 */

	$args = array(
		'page_title' 	=>	__( 'Settings', 'ninja-forms' ),
		'menu_title'	=> 	__( 'Settings', 'ninja-forms' ),
		'menu_slug'		=>	'general',
		'scope' 		=> 	'plugin_settings'
	);
	Ninja_Forms()->admin_settings_pages->register_admin_page( $args );	
}