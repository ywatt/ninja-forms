<?php 

add_action('init', 'ninja_forms_register_tab_system_status');

function ninja_forms_register_tab_system_status(){
	$args = array(
		'name' => __( 'Ninja Forms System Status', 'ninja-forms' ),
		'page' => 'ninja-forms-system-status',
		'display_function' => 'ninja_forms_tab_system_status',
		'save_function' => '',
		'show_save' => false,
	);
	ninja_forms_register_tab('system_status', $args);
}

function ninja_forms_tab_system_status(){
	// TODO Display the system status!
}