<?php
function ninja_forms_register_field($slug, $args = array()){
	global $ninja_forms_fields;

	if( !isset( $ninja_forms_fields ) ){
		$ninja_forms_fields = array();
	}

	$defaults = array(
		'conditional' => '',
		'default_label' => '',		
		'default_label_pos' => '',
		'default_value' => '',
 		'display_function' => '',
 		'display_label' => true,
 		'display_wrap' => true,
 		'edit_conditional' => true,
 		'edit_custom_class' => true,
 		'edit_function' => '',
 		'edit_help' => true,
 		'edit_label' => true,
 		'edit_label_pos' => true,
 		'edit_meta' => true,
 		'edit_options' => '',
 		'edit_req' => true,
 		'edit_sub_post_process' => '',
 		'edit_sub_pre_process' => '',
 		'edit_sub_process' => '',
 		'esc_html' => true,
		'group' => '',
		'interact' => true,
		'label_pos_options' => '',
 		'limit' => '',
 		'name' => $slug,
		'nesting' => false,
		'post_process' => '',
 		'pre_process' => '',
 		'process' => '',
 		'process_field' => true,
 		'req' => false,
 		'req_validation' => '',
 		'save_function' => '',
 		'save_sub' => true,
	 	'sub_edit' => 'text',
 		'sub_edit_function' => '',
 		'use_li' => true,
 		'visible' => 1,
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	foreach( $args as $key => $val ){
		$ninja_forms_fields[$slug][$key] = $val;
	}

}

function ninja_forms_register_field_type_group( $slug, $args ){
	global $ninja_forms_field_type_groups;

	foreach( $args as $key => $val ){
		$ninja_forms_field_type_groups[$slug][$key] = $val;
	}
}

function ninja_forms_register_tab( $slug, $args ){
	global $ninja_forms_tabs;

	if(!is_array($ninja_forms_tabs)){
		$ninja_forms_tabs = array();
	}

	$defaults = array(
		'active_class' => '',
		'add_form_id' => true,
		'disable_no_form_id' => false,
		'display_function' => '',
		'inactive_class' => '',
		'name' => '',
		'page' => '',
		'save_function' => '',
		'show_on_no_form_id' => true,
		'show_save' => true,
		'show_tab_links' => true,
		'show_this_tab_link' => true,
		'tab_reload' => false,
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	$page = $args['page'];

	foreach( $args as $key => $val ){
		$ninja_forms_tabs[$page][$slug][$key] = $val;
	}
}

function ninja_forms_register_sidebar( $slug, $args ){
	global $ninja_forms_sidebars;

	if( !is_array($ninja_forms_sidebars ) ){
		$ninja_forms_sidebars = array();
	}

	$defaults = array(
		'display_function' => 'ninja_forms_sidebar_display_fields',
		'name' => '',
		'order' => '',
		'save_function' => '',
		'settings' => ''
	);



	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	foreach( $args as $key => $val ){
		$ninja_forms_sidebars[$page][$tab][$slug][$key] = $val;
	}

}

function ninja_forms_register_sidebar_option( $slug, $args ){
	global $ninja_forms_sidebars;

	if( !is_array($ninja_forms_sidebars ) ){
		$ninja_forms_sidebars = array();
	}

	$defaults = array(
		'desc' => '',
		'display_function' => '',
		'help' => '',
		'name' => ''
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	foreach( $args as $key => $val ){
		$ninja_forms_sidebars[$page][$tab][$sidebar]['settings'][$slug][$key] = $val;
	}
}

function ninja_forms_register_sidebar_options( $args ){
	global $ninja_forms_sidebars;

	extract( $args );

	foreach( $args['settings'] as $setting ){

		$defaults = array(
			'desc' => '',
			'display_function' => '',
			'help' => '',
			'name' => ''
		);

		$slug = $setting['name'];

		// Parse incomming $setting into an array and merge it with $defaults
		$setting = wp_parse_args( $setting, $defaults );

		foreach( $setting as $key => $val ){
			$ninja_forms_sidebars[$page][$tab][$sidebar]['settings'][$slug][$key] = $val;
		}
	}

}

function ninja_forms_field_edit( $slug ){
	global $ninja_forms_fields;
	$function_name = $ninja_forms_fields[$slug]['edit_function'];
	$arguments = func_get_args();
    array_shift( $arguments ); // We need to remove the first arg ($function_name)
    call_user_func_array( $function_name, $arguments );
}

//Screen option registration function
function ninja_forms_register_screen_option( $id, $args ){
	global $ninja_forms_screen_options;

	$defaults = array(
		'display_function' => '',
		'order' => '',
		'page' => '',
		'save_function' => '',
		'tab' => '',
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	if($page == '' AND $tab == ''){
		$ninja_forms_screen_options['_universal_'][$id]['display_function'] = $display_function;
		$ninja_forms_screen_options['_universal_'][$id]['save_function'] = $save_function;
	}elseif($page != '' AND $tab == ''){
		$ninja_forms_screen_options[$page]['_universal_'][$id]['display_function'] = $display_function;
		$ninja_forms_screen_options[$page]['_universal_'][$id]['save_function'] = $save_function;
	}elseif($page != '' AND $tab != ''){
		$ninja_forms_screen_options[$page][$tab][$id]['display_function'] = $display_function;
		$ninja_forms_screen_options[$page][$tab][$id]['save_function'] = $save_function;
	}
}

//Help tab registration function
function ninja_forms_register_help_screen_tab( $id, $args ){
	global $ninja_forms_help_screen_tabs;

	$defaults = array(
		'display_function' => '',
		'order' => '',
		'page' => '',
		'tab' => '',
		'title' => '',
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	if($page == '' AND $tab == ''){
		$ninja_forms_help_screen_tabs['_universal_'][$id]['title'] = $title;
		$ninja_forms_help_screen_tabs['_universal_'][$id]['content'] = $display_function;
	}elseif($page != '' AND $tab == ''){
		$ninja_forms_help_screen_tabs[$page]['_universal_'][$id]['title'] = $title;
		$ninja_forms_help_screen_tabs[$page]['_universal_'][$id]['content'] = $display_function;
	}elseif($page != '' AND $tab != ''){
		$ninja_forms_help_screen_tabs[$page][$tab][$id]['title'] = $title;
		$ninja_forms_help_screen_tabs[$page][$tab][$id]['content'] = $display_function;
	}
}

//Tab - Metaboxes Registration function
function ninja_forms_register_tab_metabox($args = array()){
	global $ninja_forms_tabs_metaboxes;

	$defaults = array(
		'display_container' => true,
		'save_function' => '',
		'state' => ''
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	foreach($args as $key => $val){
		$ninja_forms_tabs_metaboxes[$page][$tab][$slug][$key] = $val;
	}
}

//Register Tab Metabox Options
function ninja_forms_register_tab_metabox_options( $args = array() ){
	global $ninja_forms_tabs_metaboxes;

	extract( $args );

	$new_settings = $args['settings'];

	if( isset( $ninja_forms_tabs_metaboxes[$page][$tab][$slug]['settings'] ) ){
		$settings = $ninja_forms_tabs_metaboxes[$page][$tab][$slug]['settings'];
	}else{
		$settings = array();
	}

	if( is_array( $new_settings ) AND !empty( $new_settings ) ){
		foreach( $new_settings as $s ){
			if( is_array( $settings ) ){
				array_push( $settings, $s );
			}
		}
	}

	$ninja_forms_tabs_metaboxes[$page][$tab][$slug]['settings'] = $settings;
}

function ninja_forms_register_form_settings( $args = array() ) {
	global $ninja_forms_form_settings;

	extract( $args );

	foreach( $settings as $id => $setting ) {
		$ninja_forms_form_settings[$tab][$id] = $setting;
	}
}

function ninja_forms_register_form_settings_tab( $args ) {
	global $ninja_forms_form_settings_tabs;
	
	$defaults = array(
		'priority' => 'default',
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	$ninja_forms_form_settings_tabs[$id] = $settings;
}

function register_settings_tabs() {
	$args = array(
		'id' => 'display_settings',
		'settings' => array(
			'label' => 'Display Settings',
			'class' => '',
			'priority' => 'core',
			'desc' => __( 'These settings affect how forms are displayed on the front-end.', 'ninja-forms' ),
		),
	);
	ninja_forms_register_form_settings_tab( $args );

	$args = array(
		'id' => 'success_settings',
		'settings' => array(
			'label' => 'After Submission Settings',
			'priority' => 'core',
			'desc' => __( 'These settings affect what happens after a form is submitted.', 'ninja-forms' ),
		),
	);
	ninja_forms_register_form_settings_tab( $args );
	
	$args = array(
		'id' => 'user_email_settings',
		'settings' => array(
			'label' => 'User Email Settings',
			'priority' => 'default',
			'desc' => __( 'User email settings description.', 'ninja-forms' ),
		),
	);
	ninja_forms_register_form_settings_tab( $args );

	$args = array(
		'id' => 'admin_email_settings',
		'settings' => array(
			'label' => 'Admin Email Settings',
			'priority' => 'default',
			'desc' => __( 'Admin email settings description.', 'ninja-forms' ),
		),
	);
	ninja_forms_register_form_settings_tab( $args );	

	$args = array(
		'id' => 'adv_email_settings',
		'settings' => array(
			'label' => 'Advanced Email Settings',
			'priority' => 'default',
			'desc' => __( 'Changing these settings will override your default plugin settings.', 'ninja-forms' ),
		),
	);
	ninja_forms_register_form_settings_tab( $args );	

	$args = array(
		'id' => 'test_setting',
		'settings' => array(
			'label' => 'Test Settings',
			'priority' => 'low',
			'desc' => __( 'This is just a test settings page.', 'ninja-forms' ),
		),
	);
	ninja_forms_register_form_settings_tab( $args );	
}

add_action( 'ninja_forms_register_form_settings', 'register_settings_tabs' );

function register_forms_settings() {
	$pages = get_pages();

	$pages_array = array();
	$append_array = array();
	array_push($pages_array, array('name' => __( '- None', 'ninja-forms' ), 'value' => ''));
	array_push($append_array, array('name' => __( '- None', 'ninja-forms' ), 'value' => ''));
	foreach ($pages as $pagg) {
		array_push($pages_array, array('name' => $pagg->post_title, 'value' => get_page_link($pagg->ID)));
		array_push($append_array, array('name' => $pagg->post_title, 'value' => $pagg->ID));
	}

	$args = array(
		'tab' => 'display_settings',
		'settings' => array(
			'append_page' => array(
				'type' => 'select',
				'desc' => '',
				'label' => __( 'Add this form to the bottom of this page:', 'ninja-forms' ),
				'options' => $append_array,
				'class' => 'widefat code',
			),			
			'logged_in' => array(
				'type' => 'checkbox',
				'label' => __( 'Only show this form to logged-in users?', 'ninja-forms' ),
			),
			'ajax' => array(
				'type' => 'checkbox',
				'label' => __( 'Submit the form without reloading the page? (Via Ajax)', 'ninja-forms' ),
			),			
			'show_title' => array(
				'type' => 'checkbox',
				'label' => __( 'Output the form title above form?', 'ninja-forms' ),
			),
		),
	);
	ninja_forms_register_form_settings( $args );

	$args = array(
		'tab' => 'success_settings',
		'settings' => array(
			'success_msg' => array(
				'type' => 'rte',
				'label' => __( 'Success Message', 'ninja-forms' ),
				'desc' => __( 'If you want to include field data entered by the user, for instance a name, you can use the following shortcode: [ninja_forms_field id=23] where 23 is the ID of the field you want to insert. This will tell Ninja Forms to replace the bracketed text with whatever input the user placed in that field. You can find the field ID when you expand the field for editing.', 'ninja-forms' ),
			),
			'landing_page' => array(
				'type' => 'select',
				'label' => __( 'Show this page after successful submission:', 'ninja-forms' ),
				'options' => $pages_array,
				'class' => 'widefat code',
			),			
			'save_subs' => array(
				'type' => 'checkbox',
				'label' => __( 'Save form submissions into the Ninja Forms database?', 'ninja-forms' ),
				'default_value' => 1,
			),

			'clear_complete' => array(
				'type' => 'checkbox',
				'label' => __( 'Clear the form after successful submission?', 'ninja-forms' ),
				'default_value' => 1,
			),			
			'hide_complete' => array(
				'type' => 'checkbox',
				'label' => __( 'Hide the form after successful submission?', 'ninja-forms' ),
				'default_value' => 1,
			),
		),
	);
	ninja_forms_register_form_settings( $args );
	
	$args = array(
		'tab' => 'user_email_settings',
		'settings' => array(
			'user_email_subject' => array(
				'type' => 'text',
				'label' => __( 'Email subject sent to the user:', 'ninja-forms' ),
				'class' => 'widefat code',
			),
			'user_email_msg' => array(
				'type' => 'rte',
				'label' => __( 'Email message sent to the user:', 'ninja-forms' ),
				'class' => 'widefat code',
			),
			'user_email_fields' => array(
				'type' => 'checkbox',
				'label' => __( 'Include a list of fields?', 'ninja-forms' ),
			),
			'user_email_test' => array(
				'type' => 'rte',
				'label' => __( 'Email message sent to the user:', 'ninja-forms' ),
				'class' => 'widefat code',
			),
		),
	);
	ninja_forms_register_form_settings( $args );

	$args = array(
		'tab' => 'admin_email_settings',
		'settings' => array(
			'admin_mailto' => array(
				'type' => 'repeater-text',
				'label' => __( 'Send an email to these addresses:', 'ninja-forms' ),
				'class' => 'code',
				'default_value' => array(),
			),
			'admin_email_subject' => array(
				'type' => 'text',
				'label' => __( 'Email subject sent to the administrators:', 'ninja-forms' ),
				'class' => 'widefat code',
			),
			'admin_email_msg' => array(
				'type' => 'rte',
				'label' => __( 'Email message sent to the administrators:', 'ninja-forms' ),
				'class' => 'widefat code',
			),
			'admin_email_fields' => array(
				'type' => 'checkbox',
				'label' => __( 'Include a list of fields?', 'ninja-forms' ),
				'default_value' => 1,
			),
			'admin_attach_csv' => array(
				'type' => 'checkbox',
				'label' => __( 'Attach CSV of submission?', 'ninja-forms' ),
				'default_value' => 0,
			),

		),
	);
	ninja_forms_register_form_settings( $args );	

	$args = array(
		'tab' => 'adv_email_settings',
		'settings' => array(
			'email_from' => array(
				'type' => 'text',
				'label' => __( 'Email From Address', 'ninja-forms' ),
				'desc' => htmlspecialchars( __( 'Steve Jones <steve@myurl.com>', 'ninja-forms' ) ),
			),
			'email_type' => array(
				'type' => 'select',
				'label' => __( 'Email Type', 'ninja-forms' ),
				'options' => array(
					array('name' => __( 'HTML', 'ninja-forms' ), 'value' => 'html'),
					array('name' => __( 'Plain Text', 'ninja-forms' ), 'value' => 'plain'),
				),
			),
		),
	);
	ninja_forms_register_form_settings( $args );

	$args = array(
		'tab' => 'test_setting',
		'settings' => array(
			'test' => array(
				'type' => 'checkbox',
				'label' => __( 'CHECK ME!', 'ninja-forms' ),
				'desc' => 'HELLO WORLD!',
			),
		),
	);
	ninja_forms_register_form_settings( $args );
}

add_action( 'ninja_forms_register_form_settings', 'register_forms_settings' );