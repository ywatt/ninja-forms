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

	$defaults = array(
		'class' => '',
		'default_value' => '',		
		'desc' => '',
		'label' => '',
		'options' => '',				
		'type' => '',
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	$tab = $args['tab'];
	unset( $args['tab'] );

	if ( !isset ( $ninja_forms_form_settings[$tab] ) ) {
		$ninja_forms_form_settings[$tab] = array();		
	}

	$ninja_forms_form_settings[$tab] = array_merge( $ninja_forms_form_settings[$tab], $args['settings'] );
}

function ninja_forms_rest_put_filter( $value, $form_setting, $form_id ) {
	global $ninja_forms_form_settings;
	if ( is_array ( $ninja_forms_form_settings ) ) {
		foreach ( $ninja_forms_form_settings as $tab => $settings ) {
			foreach ( $settings as $id => $setting ) {
				if ( $id == $form_setting and isset ( $setting['put_filter'] ) ) {
					if ( is_string( $setting['put_filter'] ) and function_exists ( $setting['put_filter'] ) ) {
						$value = call_user_func( $setting['put_filter'], $value, $form_setting, $form_id );
					} else if ( is_callable( $setting['put_filter'] ) ) {
						$value = $setting['put_filter']( $value, $form_setting, $form_id );
					}
				}
			}
		}	
	}
	return $value;
}

add_filter( 'ninja_forms_rest_put_value', 'ninja_forms_rest_put_filter', 10, 3 );

function ninja_forms_register_form_settings_tab( $args ) {
	global $ninja_forms_form_settings_tabs;

	$defaults = array(
		'priority' => 'default',
		'display_link' => true,
	);

	// Parse incomming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );
	
	$id = $args['id'];
	unset( $args['id'] );

	if ( isset ( $args['settings'] ) and is_array( $args['settings'] ) ) {
		$settings_args = array(
			'tab' => $id,
			'settings' => $args['settings'],
		);
		ninja_forms_register_form_settings( $settings_args );
		unset( $args['settings'] );
	}

	foreach ( $args as $key => $val ) {
		$ninja_forms_form_settings_tabs[$id][$key] = $val;
	}
	
}

function register_settings_tabs() {
	$args = array(
		'id' => 'display_settings',
		'label' => 'Display',
		'class' => '',
		'priority' => 'core',
		'desc' => __( 'These settings affect how forms are displayed on the front-end.', 'ninja-forms' ),

	);
	ninja_forms_register_form_settings_tab( $args );

	$args = array(
		'id' => 'success_settings',
		'label' => 'After Submission',
		'priority' => 'core',
		'desc' => __( 'These settings affect what happens after a form is submitted.', 'ninja-forms' ),
	);
	//ninja_forms_register_form_settings_tab( $args );

	$args = array(
		'id' => 'notifications',
		'label' => 'Notifications',
		'priority' => 'default',
		'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
		'custom' => true,
		'template' => 
			'<div id="" class="tablenav top">
				<div class="alignleft" style="margin-right:15px">
					<a href="#" class="button-primary">'.__( 'Add New', 'ninja-forms' ).'</a>
				</div>
				<div class="alignleft actions">
					<select id="" class="" name="bulk_action">
						<option value="">'.__( 'Bulk Actions', 'ninja-forms' ).'</option>
						<option value="delete">'.__( 'Activate', 'ninja-forms' ).'</option>
						<option value="delete">'.__( 'Deactivate', 'ninja-forms' ).'</option>
						<option value="delete">'.__( 'Delete', 'ninja-forms' ).'</option>
					</select>
					<input type="submit" name="submit" value="'.__( 'Apply', 'ninja-forms' ).'" class="button-secondary">
				</div>
				<div class="alignleft actions">
					<select id="" name="limit">
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					'.__( 'Notifications Per Page', 'ninja-forms' ).'
					<input type="submit" name="submit" value="'.__( 'Go', 'ninja-forms' ).'" class="button-secondary">
				</div>
			</div>
			<table class="wp-list-table widefat fixed posts">
				<thead>
					<tr>
						<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
						<th>'.__( 'Name', 'ninja-forms' ).'</th>
						<th>'.__( 'Type', 'ninja-forms' ).'</th>
						<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
					</tr>
				</thead>
				<tbody>
				<% _.each(settings, function(setting){ %>
					<tr>
						<th scope="row" class="check-column">
							<input type="checkbox" id="" name="notification_ids[]" value="" class="ninja-forms-bulk-action">
						</th>

						<td class="post-title page-title column-title">
							<strong>
								<a href="#notification_single" class="media-menu-item" id="notification_single" title="" data-notification-id="<%= setting.get( "id" ) %>" ><%= setting.get( "name" ) %></a>
							</strong>
							<div class="row-actions">
								<span class="activate"><a href="">'.__( 'Activate', 'ninja-forms' ).'</a> | </span>
								<span class="trash"><a class="ninja-forms-delete-form" title="'.__( 'Delete this notification', 'ninja-forms' ).'" href="#" id="">'.__( 'Delete', 'ninja-forms' ).'</a> | </span>
								<span class="export"><a href="" title="'.__( 'Export Form', 'ninja-forms' ).'">'.__( 'Export', 'ninja-forms' ).'</a> | </span>
								<span class="duplicate"><a href="" title="'.__( 'Duplicate Form', 'ninja-forms' ).'">'.__( 'Duplicate', 'ninja-forms' ).'</a></span>
							</div>
						</td>
						<td>
							<%= setting.get( "type" ) %>
						</td>
						<td>
							6 January 2014
						</td>
					</tr>
					<% }); %>
				</tbody>
				<tfoot>
					<tr>
						<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
						<th>'.__( 'Name', 'ninja-forms' ).'</th>
						<th>'.__( 'Type', 'ninja-forms' ).'</th>
						<th>'.__( 'Date Updated', 'ninja-forms' ).'</th>
					</tr>
				</tfoot>
			</table>',
		'settings' => array(
			'test' => array(
				'type' => 'array',
			),
		),
		//'put_filter' => function( $value, $form_setting, $form_id ) { return $value; }
	);
	ninja_forms_register_form_settings_tab( $args );

	$args = array(
		'id' => 'notification_single',
		'label' => 'Notifications',
		'display_link' => false,
		'priority' => 'default',
		'desc' => __( 'This is where all form notifications are managed.', 'ninja-forms' ),
		//'put_filter' => function( $value, $form_setting, $form_id ) { return $value; }
	);
	ninja_forms_register_form_settings_tab( $args );
}

add_action( 'ninja_forms_admin_init', 'register_settings_tabs' );

/**
 * 
 * 
 */

function nf_filter_rest_get_notifications( $args, $form_id, $tab, $data ) {
	if ( $tab != 'notifications' )
		return $args;

	$notifications = nf_get_notifications_by_form_id( $form_id );
	$tmp_array = array();
	$x = 0;
	foreach( $notifications as $id => $settings ) {
		$tmp_array[$x]['id'] = $id;
		foreach( $settings as $key => $value ) {
			$tmp_array[$x][$key] = $value;
		}
		$x++;
	}

	return $tmp_array;
}

add_filter( 'nf_rest_get_array', 'nf_filter_rest_get_notifications', 10, 4 );

function nf_filter_rest_get_single_notification( $args, $form_id, $tab, $data ) {
	if ( $tab != 'notification_single' )
		return $args;

	$id = $data['notificationId'];

	$notification = nf_get_notification_by_id( $id );

	for ( $i=0; $i < count( $args ); $i++ ) { 
		if ( isset ( $notification[ $args[ $i ]['id'] ] ) ) {
			$args[ $i ]['current_value'] = $notification[ $args[ $i ]['id'] ];
		}	
	}

	return $args;
}

add_filter( 'nf_rest_get_array', 'nf_filter_rest_get_single_notification', 10, 4 );

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
				'type' => 'dropdown',
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
		'tab' => 'display_settings',
		'settings' => array(
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
			'sub_limit_number' => array(
				'type' => 'number',
				'label' => __( 'Limit Submissions', 'ninja-forms' ),
				'min' => 0,
				'desc' => __( 'Select the number of submissions that this form will accept. Leave empty for no limit.', 'ninja-forms' ),
			),
		),
	);
	ninja_forms_register_form_settings( $args );

	$args = array(
		'tab' => 'notification_single',
		'settings' => array(
			'type' => array(
				'type' => 'dropdown',
				'label' => __( 'Type', 'ninja-forms' ),
				'options' => array(
					array('name' => __( 'Email', 'ninja-forms' ), 'value' => 'email'),
					array('name' => __( 'Success Message', 'ninja-forms' ), 'value' => 'success_message'),
					array('name' => __( 'Pushover', 'ninja-forms' ), 'value' => 'pushover'),
					array('name' => __( 'Text Message', 'ninja-forms' ), 'value' => 'text_message'),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
			),
			'name' => array(
				'type' => 'text',
				'label' => __( 'Name', 'ninja-forms' ),
				'class' => 'widefat',
				'desc' => __( 'How would you like to identify this notification?', 'ninja-forms' ),
			),
			'mailto' => array(
				'type' => 'radio',
				'label' => __( 'Send To', 'ninja-forms' ),
				'options' => array(
					array('name' => __( 'Enter Email', 'ninja-forms' ), 'value' => 'manual_email'),
					array('name' => __( 'Select a Field', 'ninja-forms' ), 'value' => 'field_value'),
					array('name' => __( 'Configure Routing', 'ninja-forms' ), 'value' => 'configure_routing'),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
			),
		),
	);
	ninja_forms_register_form_settings( $args );
}

add_action( 'ninja_forms_admin_init', 'register_forms_settings' );