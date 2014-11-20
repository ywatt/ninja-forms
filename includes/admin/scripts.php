<?php
//Load up our WP Ninja Custom Form JS files.
function ninja_forms_admin_css(){
	$plugin_settings = nf_get_settings();

	wp_enqueue_style( 'jquery-smoothness', NINJA_FORMS_URL .'css/smoothness/jquery-smoothness.css');
	wp_enqueue_style( 'ninja-forms-admin', NINJA_FORMS_URL .'css/ninja-forms-admin.css');

	add_filter('admin_body_class', 'ninja_forms_add_class');

}

function ninja_forms_add_class($classes) {
	// add 'class-name' to the $classes array
	$classes .= ' nav-menus-php';
	// return the $classes array
	return $classes;
}

function ninja_forms_admin_js(){
	global $version_compare;

	if ( defined( 'NINJA_FORMS_JS_DEBUG' ) && NINJA_FORMS_JS_DEBUG ) {
		$suffix = '';
		$src = 'dev';
	} else {
		$suffix = '.min';
		$src = 'min';
	}

	$plugin_settings = nf_get_settings();
	if(isset($plugin_settings['date_format'])){
		$date_format = $plugin_settings['date_format'];
	}else{
		$date_format = 'm/d/Y';
	}

	$date_format = ninja_forms_date_to_datepicker($date_format);

	wp_enqueue_script('ninja-forms-admin',
	NINJA_FORMS_URL . 'js/' . $src .'/ninja-forms-admin' . $suffix . '.js',
	array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'jquery-ui-draggable', 'jquery-ui-droppable'));

	wp_localize_script( 'ninja-forms-admin', 'ninja_forms_settings', array('date_format' => $date_format, 'nf_ajax_nonce' => wp_create_nonce( 'nf_ajax') ) );

	if ( isset ( $_REQUEST['page'] ) && $_REQUEST['page'] == 'ninja-forms' && isset ( $_REQUEST['tab'] ) && $_REQUEST['tab'] == 'fields' ) {
		wp_enqueue_script( 'nf-admin-fields',
			NINJA_FORMS_URL . 'assets/js/' . $src .'/admin-fields' . $suffix . '.js' );

		$form_id = isset ( $_REQUEST['form_id'] ) ? $_REQUEST['form_id'] : '';

		if ( '' != $form_id ) {
			$fields = Ninja_Forms()->form( $form_id )->fields;

			$current_tab = ninja_forms_get_current_tab();
			$current_page = isset ( $_REQUEST['page'] ) ? esc_html( $_REQUEST['page'] ) : '';

			foreach ( $fields as $field_id => $field ) {
				$slug = 'field_' . $field_id;
				if ( isset ( $plugin_settings['metabox_state'][ $current_page ][ $current_tab ][ $slug ] ) && $plugin_settings['metabox_state'][ $current_page ][ $current_tab ][ $slug ] == 'display:none;' ) {
					$state = 0;
				} else {
					$state = 1;
				}

				$fields[ $field_id ]['metabox_state'] = $state;
			}

			wp_localize_script( 'nf-admin-fields', 'nf_admin', array( 'fields' => $fields ) );
		}		
	}
}
