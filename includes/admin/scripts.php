<?php
//Load up our WP Ninja Custom Form JS files.
function ninja_forms_admin_css(){
	$plugin_settings = get_option('ninja_forms_settings');

	wp_enqueue_style( 'jquery-smoothness', NF_PLUGIN_URL .'css/smoothness/jquery-smoothness.css');
	wp_enqueue_style( 'ninja-forms-admin', NF_PLUGIN_URL .'css/ninja-forms-admin.css');

	add_filter('admin_body_class', 'ninja_forms_add_class');

}

function ninja_forms_font_css() {
	if ( is_admin() ) {
		wp_enqueue_style( 'ninja-forms-fonts', NF_PLUGIN_URL .'css/fonts.css');
	}
}
add_action( 'admin_init', 'ninja_forms_font_css' );

function ninja_forms_add_class($classes) {
	// add 'class-name' to the $classes array
	$classes .= ' nav-menus-php';
	// return the $classes array
	return $classes;
}

function ninja_forms_admin_js(){
	global $version_compare;

	$plugin_settings = get_option("ninja_forms_settings");
	if(isset($plugin_settings['date_format'])){
		$date_format = $plugin_settings['date_format'];
	}else{
		$date_format = 'm/d/Y';
	}

	wp_enqueue_script( 'jquery-modal',
	NF_PLUGIN_URL .'js/min/jquery.modal.min.js',
	array( 'jquery', 'jquery-ui-core' ) );


	$date_format = ninja_forms_date_to_datepicker($date_format);

	wp_enqueue_script('ninja-forms-admin',
	NF_PLUGIN_URL .'js/dev/ninja-forms-admin.js',
	array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'jquery-ui-draggable', 'jquery-ui-droppable', 'backbone' ));

	wp_localize_script( 'ninja-forms-admin', 'ninja_forms_settings', array('date_format' => $date_format));
	if ( isset ( $_REQUEST['form_id'] ) ) {
		$form_id = $_REQUEST['form_id'];
	} else {
		$form_id = '';
	}
	wp_localize_script( 'ninja-forms-admin', 'form_id', $form_id );
	wp_localize_script( 'ninja-forms-admin', 'admin_url', admin_url( 'admin.php' ) );
	
}

function ninja_forms_new_form_js() {
	wp_enqueue_script('ninja-forms-new-form',
		NINJA_FORMS_URL .'/js/dev/new-form.js',
		array( 'jquery', 'ninja-forms-admin' ) );
	wp_localize_script( 'ninja-forms-new-form', 'ninja_forms_rest_url', admin_url( 'admin.php?page=ninja-forms' ) );
}

function ninja_forms_edit_form_js() {
	wp_enqueue_script('ninja-forms-edit-form',
		NINJA_FORMS_URL .'/js/dev/edit-form.js',
		array( 'jquery', 'ninja-forms-admin' ) );
	wp_localize_script( 'ninja-forms-edit-form', 'ninja_forms_rest_url', admin_url( 'admin.php?page=ninja-forms' ) );
}