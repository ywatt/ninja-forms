<?php

/**
 * Deprecated as of version 2.7.
 */

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

add_filter( 'nf_subs_csv_field_label', 'nf_old_subs_csv_label', 10, 2 );

// Hook into our new submissions CSV label array filter.
function nf_old_subs_csv_label_array( $label_array, $sub_ids ) {
	return apply_filters( 'ninja_forms_export_subs_label_array', $label_array, $sub_ids );
}

add_filter( 'nf_subs_csv_label_array', 'nf_old_subs_csv_label_array', 10, 2 );

// Hook into our new submissions CSV pre_value filter.
function nf_old_subs_csv_pre_value( $user_value, $field_id ) {
	return apply_filters( 'ninja_forms_export_sub_pre_value', $user_value, $field_id );
}

add_filter( 'nf_subs_export_pre_value', 'nf_old_subs_csv_pre_value', 10, 2 );

// Hook into our new submissions CSV value filter.
function nf_old_subs_csv_value( $user_value, $field_id ) {
	return apply_filters( 'ninja_forms_export_sub_value', $user_value, $field_id );
}

add_filter( 'nf_subs_csv_field_value', 'nf_old_subs_csv_value', 10, 2 );

// Hook into our new submissions CSV value array filter.
function nf_old_subs_csv_value_array( $values_array, $sub_ids ) {
	return apply_filters( 'ninja_forms_export_subs_value_array', $values_array, $sub_ids );
}

add_filter( 'nf_subs_csv_value_array', 'nf_old_subs_csv_value_array', 10, 2 );

// Hook into our new CSV BOM filter
function nf_old_subs_csv_bom( $bom ) {
	return apply_filters( 'ninja_forms_csv_bom', $bom );
}

add_filter( 'nf_sub_csv_bom', 'nf_old_subs_csv_bom' );

// Hook into our new CSV delimiter filter
function nf_old_subs_csv_delimiter( $delimiter ) {
	return apply_filters( 'ninja_forms_csv_delimiter', $delimiter );
}

add_filter( 'nf_sub_csv_delimiter', 'nf_old_subs_csv_delimiter' );

// Hook into our new CSV enclosure filter
function nf_old_subs_csv_enclosure( $enclosure ) {
	return apply_filters( 'ninja_forms_csv_enclosure', $enclosure );
}

add_filter( 'nf_sub_csv_enclosure', 'nf_old_subs_csv_enclosure' );

// Hook into our new CSV terminator filter
function nf_old_subs_csv_terminator( $terminator ) {
	return apply_filters( 'ninja_forms_csv_terminator', $terminator );
}

add_filter( 'nf_sub_csv_terminator', 'nf_old_subs_csv_terminator' );

// Hook into our new Submissions table row-actions filter
function nf_old_subs_table_row_actions_filter( $actions, $sub_id, $form_id ) {
	return apply_filters( 'ninja_forms_sub_table_row_actions', array(), false, $sub_id, $form_id );
}

add_filter( 'nf_sub_table_row_actions', 'nf_old_subs_table_row_actions_filter', 10, 3 );

/**
 * ninja_forms_get_subs() has been deprecated in favour of Ninja_Forms()->subs()->get( $args ) or Ninja_Forms()->form( 23 )->get_subs( $args )
 * You can also use WordPress queries ,since this is a custom post type.
 * 
 * @since 2.7
 */

function ninja_forms_get_subs( $args = array() ) {

	$plugin_settings = nf_get_settings();

	if ( isset ( $plugin_settings['date_format'] ) ) {
		$date_format = $plugin_settings['date_format'];
	} else {
		$date_format = 'm/d/Y';
	}

	if( is_array( $args ) AND ! empty( $args ) ) {

		$subs_results = array();
		$meta_query = array();
		$date_query = array();

		if( isset( $args['form_id'] ) ) {
			$meta_query[] = array(
				'key' => '_form_id',
				'value' => $args['form_id'],
			);
		}

		if( isset( $args['user_id'] ) ) {
			$query_args['author'] = $args['user_id'];
		}

		if( isset( $args['action'])){
			$meta_query[] = array(
				'key' => '_action',
				'value' => $args['action'],
			);
		}

		if( isset( $args['begin_date'] ) AND $args['begin_date'] != '') {
			$query_args['date_query']['after'] = nf_get_begin_date( $args['begin_date'] )->format("Y-m-d G:i:s");
		}

		if( isset( $args['end_date'] ) AND $args['end_date'] != '' ) {
			$query_args['date_query']['before'] = nf_get_end_date( $args['end_date'] )->format("Y-m-d G:i:s");
		}

		$query_args = array(
			'post_type' 	=> 'nf_sub',
			'date_query' 	=> $date_query,
			'meta_query' 	=> $meta_query,
			'posts_per_page'	=> -1,
		);

		$subs = get_posts( $query_args );

		if ( is_array( $subs ) && ! empty( $subs ) ) {
			$x = 0;
			foreach ( $subs as $sub ) {
				$data = array();
				$subs_results[$x]['id'] = $sub->ID;
				$subs_results[$x]['user_id'] = $sub->post_author;
				$subs_results[$x]['form_id'] = get_post_meta( $sub->ID, '_form_id' );
				$subs_results[$x]['action'] = get_post_meta( $sub->ID, '_action' );

				$meta = get_post_custom( $sub->ID );

				foreach ( $meta as $key => $array ) {
					if ( strpos( $key, '_field_' ) !== false ) {
						$field_id = str_replace( '_field_', '', $key );
						$user_value = $array[0];
						$data[] = array( 'field_id' => $field_id, 'user_value' => $user_value );
					}
				}

				$subs_results[$x]['data'] = $data;
				$subs_results[$x]['date_updated'] = $sub->post_modified;

				$x++;
			}
		}

		return $subs_results;
	}
}

/**
 * ninja_forms_get_sub_count() has been deprecated in favour of Ninja_Forms()->form( 23 )->sub_count or nf_get_sub_count()
 * Function that returns a count of the number of submissions.
 *
 * @since 2.7
 */

function ninja_forms_get_sub_count( $args = array() ) {
	return count( ninja_forms_get_subs( $args ) );
}

/**
 * ninja_forms_get_sub_by_id( $sub_id ) has been deprecated in favour of Ninja_Forms()->sub( 23 );
 * 
 * @since 2.7
 */

function ninja_forms_get_sub_by_id( $sub_id ) {
	$sub = Ninja_Forms()->sub( $sub_id );
	if ( $sub ) {
		$sub_row = array();
		$data = array();
		$sub_row['id'] = $sub_id;
		$sub_row['user_id'] = $sub->user_id;
		$sub_row['form_id'] = $sub->form_id;
		$sub_row['action'] = $sub->action;

		if ( $sub->action == 'submit' ) {
			$sub_row['status'] = 1;
		} else {
			$sub_row['status'] = 0;
		}

		$meta = get_post_custom( $sub_id );

		foreach ( $meta as $key => $array ) {
			if ( strpos( $key, '_field_' ) !== false ) {
				$field_id = str_replace( '_field_', '', $key );
				$user_value = is_serialized( $array[0] ) ? unserialize( $array[0] ) : $array[0];
				$data[] = array( 'field_id' => $field_id, 'user_value' => $user_value );
			}
		}

		$sub_row['data'] = $data;
		$sub_row['date_updated'] = $sub->date_submitted;

		return $sub_row;
	} else {
		return false;
	}
}

/**
 * ninja_forms_get_all_subs() has been deprecated in favour of Ninja_Forms()->subs()->get();
 * 
 * @since 2.7
 */

 function ninja_forms_get_all_subs( $form_id = '' ){
	if ( $form_id == '' )
		return false;

	$args = array( 'form_id' => $form_id );
	return ninja_forms_get_subs( $args );
}

/**
 * ninja_forms_insert_sub() has been deprecated in favour of Ninja_Forms()->subs()->create( $form_id );
 * Because submissions are now a CPT, this function will only return false. 
 * Please replace any instances of this function with the replacement.
 * 
 * @since 2.7
 */

function ninja_forms_insert_sub( $args ) {

	if ( ! isset ( $args['form_id'] ) )
		return false;

	$form_id = $args['form_id'];
	
	$sub_id = Ninja_Forms()->subs()->create( $form_id );
	$args['sub_id'] = $sub_id;

	ninja_forms_update_sub( $args );

	return $sub_id;
}

/**
 * ninja_forms_update_sub() has been deprecated in favour of Ninja_Forms()->sub( 23 )->update_field( id, value );
 * Because submissions are now a CPT, this function will only return false. 
 * Please replace any instances of this function with the replacement.
 * 
 * @since 2.7
 */

function ninja_forms_update_sub( $args ){
	if ( ! isset ( $args['sub_id'] ) )
		return false;

	$sub_id = $args['sub_id'];
	$sub = Ninja_Forms()->sub( $sub_id );

	if ( isset ( $args['data'] ) ) {
		$data = $args['data'];
		unset ( $args['data'] );

		if ( is_serialized( $data ) ) {
			$data = unserialize( $data );

			foreach ( $data as $d ) {
				$field_id = $d['field_id'];
				$user_value = $d['user_value'];
				$sub->add_field( $field_id, $user_value );
			}
		}		
	}

	foreach ( $args as $key => $value ) {
		$sub->update_meta( '_' . $key, $value );
	}

}

/**
 * ninja_forms_export_subs_to_csv() has been deprecated in favour of Ninja_Forms()->subs()->export( sub_ids, return );
 * or Ninja_Forms()->sub( 23 )->export( return );
 * Please replace any instances of this function with the replacement.
 * 
 * @since 2.7
 */

function ninja_forms_export_subs_to_csv( $sub_ids = '', $return = false ){
	Ninja_Forms()->subs()->export( $sub_ids, $return );
}

function ninja_forms_implode_r($glue, $pieces){
	$out = '';
	foreach ( $pieces as $piece ) {
		if ( is_array ( $piece ) ) {
			if ( $out == '' ) {
				$out = ninja_forms_implode_r($glue, $piece);
			} else {
				$out .= ninja_forms_implode_r($glue, $piece); // recurse
			}			
		} else {
			if ( $out == '' ) {
				$out .= $piece;
			} else {
				$out .= $glue.$piece;
			}
		}
	}
	return $out;
}


/**
 * Get the csv delimiter
 * 
 * @return string
 */
function ninja_forms_get_csv_delimiter() {
	return apply_filters( 'ninja_forms_csv_delimiter', ',' );
}


/**
 * Get the csv enclosure
 * 
 * @return string
 */
function ninja_forms_get_csv_enclosure() {
	return apply_filters( 'ninja_forms_csv_enclosure', '"' );
}


/**
 * Get the csv delimiter
 * 
 * @return string
 */
function ninja_forms_get_csv_terminator() {
	return apply_filters( 'ninja_forms_csv_terminator', "\n" );
}

/**
 * Wrapper for nf_save_sub()
 */
function ninja_forms_save_sub() {
	nf_save_sub();
}

/**
 * Pre 2.0 conversion/activation code
 */
function nf_pre_20_activation( $current_version ) {
	global $wpdb;

	$forms = '';

	if($wpdb->get_var("SHOW COLUMNS FROM ".NINJA_FORMS_TABLE_NAME." LIKE 'title'") == 'title') {
		$forms = ninja_forms_activation_old_forms_check();

		if($wpdb->get_var("SHOW TABLES LIKE '".NINJA_FORMS_TABLE_NAME."'") == NINJA_FORMS_TABLE_NAME) {
			$wpdb->query("DROP TABLE ".NINJA_FORMS_TABLE_NAME);
		}

		if($wpdb->get_var("SHOW TABLES LIKE '".NINJA_FORMS_FIELDS_TABLE_NAME."'") == NINJA_FORMS_FIELDS_TABLE_NAME) {
			$wpdb->query("DROP TABLE ".NINJA_FORMS_FIELDS_TABLE_NAME);
		}

		if($wpdb->get_var("SHOW TABLES LIKE '".NINJA_FORMS_SUBS_TABLE_NAME."'") == NINJA_FORMS_SUBS_TABLE_NAME) {
			$wpdb->query("DROP TABLE ".NINJA_FORMS_SUBS_TABLE_NAME);
		}
	}

	if( is_array( $forms ) AND !empty( $forms ) ){
 		foreach( $forms as $form ){
	 		$form['data'] = serialize( $form['data'] );
	 		if ( isset( $form['field'] ) ){
	 			$form_fields = $form['field'];
	 		}else{
	 			$form_fields = '';
	 		}

	 		if( isset( $form['subs'] ) ){
	 			$form_subs = $form['subs'];
	 		}else{
	 			$form_subs = '';
	 		}

	 		unset( $form['field'] );
	 		unset( $form['subs'] );

			$wpdb->insert(NINJA_FORMS_TABLE_NAME, $form);
			$form_id = $wpdb->insert_id;

			if( is_array( $form_fields ) AND !empty( $form_fields ) ){
				for( $x=0; $x < count( $form_fields ); $x++ ) {
					$form_fields[$x]['form_id'] = $form_id;
					$form_fields[$x]['data'] = serialize( $form_fields[$x]['data'] );
					unset( $form_fields[$x]['id'] );
					if( isset( $form_fields[$x]['old_id'] ) ){
						$old_id = $form_fields[$x]['old_id'];
						unset( $form_fields[$x]['old_id'] );
					}
					$wpdb->insert( NINJA_FORMS_FIELDS_TABLE_NAME, $form_fields[$x] );
					$new_id = $wpdb->insert_id;
					if( is_array( $form_subs ) AND !empty( $form_subs ) ){
						for ($i=0; $i < count( $form_subs ); $i++) {
							$form_subs[$i]['form_id'] = $form_id;
							if( is_array( $form_subs[$i]['data'] ) AND !empty( $form_subs[$i]['data'] ) ){
								for ($y=0; $y < count( $form_subs[$i]['data'] ); $y++){
									if( isset( $form_subs[$i]['data'][$y]['old_id'] ) AND $form_subs[$i]['data'][$y]['old_id'] == $old_id ){
										unset( $form_subs[$i]['data'][$y]['old_id'] );
										$form_subs[$i]['data'][$y]['field_id'] = $new_id;
									}
								}
							}
						}
					}
				}
			}

			if( is_array( $form_subs ) AND !empty( $form_subs ) ){
				for ($i=0; $i < count( $form_subs ); $i++) {
					$form_subs[$i]['data'] = serialize( $form_subs[$i]['data'] );
					$wpdb->insert( NINJA_FORMS_SUBS_TABLE_NAME, $form_subs[$i] );
				}
			}
 		}
 	}
}

function nf_pre_20_opts() {
	$plugin_settings = nf_get_settings();

	if( isset( $plugin_settings['upload_dir'] ) ){
		$base_upload_dir = $plugin_settings['upload_dir'];
	}else{
		$base_upload_dir = '';
	}
	if( isset( $plugin_settings['upload_size'] ) ){
		$max_file_size = $plugin_settings['upload_size'];
	}else{
		$max_file_size = 2;
	}

	$opt = array(
		'license_key' => '',
		'license_status' => 'inactive',
		'date_format' => 'm/d/Y',
		'currency_symbol' => '$',
		'clear_complete' => 1,
		'hide_complete' => 1,
		'req_div_label' => __('Fields marked with a * are required.', 'ninja-forms'),
		'req_field_symbol' => '*',
		'req_error_label' => __( 'Please ensure all required fields are completed.', 'ninja-forms' ),
		'req_field_error' => __( 'This is a required field.', 'ninja-forms' ),
		'spam_error' => __( 'Please answer the anti-spam question correctly.', 'ninja-forms' ),
		'honeypot_error' => __('If you are a human, please leave this field blank.', 'ninja-forms' ),
		'timed_submit_error' => __('If you are a human, please slow down.', 'ninja-forms' ),
		'javascript_error' => __( 'You need JavaScript to submit this form. Please enable it and try again.', 'ninja-forms' ),
		'invalid_email' => __( 'Please enter a valid email address.', 'ninja-forms' ),
		'process_label' => __('Processing', 'ninja-forms'),
		'login_link' => __('Login', 'ninja-forms'),
		'username_label' => __('Username', 'ninja-forms'),
		'reset_password' => __('Reset Password (Opens in a new window)', 'ninja-forms'),
		'password_label' => __('Password', 'ninja-forms'),
		'repassword_label' => __('Re-enter Password', 'ninja-forms'),
		'password_mismatch' => __('Passwords do not match.', 'ninja-forms'),
		'login_button_label' => __('Login', 'ninja-forms'),
		'cancel_button_label' => __('Cancel', 'ninja-forms'),
		'login_error' => __('Login failed, please try again.', 'ninja-forms'),
		'register_link' => __('Register', 'ninja-forms'),
		'email_label' => __('Email Address', 'ninja-forms'),
		'register_button_label' => __('Register', 'ninja-forms'),
		'register_error' => __('There was an error registering you for this site.', 'ninja-forms'),
		'register_spam_q' => __('4 + 9 = ', 'ninja-forms'),
		'register_spam_a' => __('13', 'ninja-forms'),
		'register_spam_error' => __('Please answer the anti-spam question correctly.', 'ninja-forms'),
		'msg_format' => 'inline',
		'base_upload_dir' => $base_upload_dir,
		'max_file_size' => $max_file_size,
	);
	
	return $opt;
}

function ninja_forms_activation_old_forms_check(){
	global $wpdb;
	//Get the current plugin settings.
	$plugin_settings = nf_get_settings();

	$current_version = $plugin_settings['version'];

	//if( version_compare( $current_version, '2.0' , '<' ) ){

		if($wpdb->get_var("SHOW COLUMNS FROM ".NINJA_FORMS_TABLE_NAME." LIKE 'title'") == 'title') {
			$all_forms = $wpdb->get_results( "SELECT * FROM ".NINJA_FORMS_TABLE_NAME, ARRAY_A );
			if( is_array( $all_forms ) AND !empty( $all_forms ) ){
				$forms = array();
				$x = 0;
				foreach( $all_forms as $form ){
					$form_id = $form['id'];
					$forms[$x]['data']['form_title'] = $form['title'];
					if( $form['show_title'] == 'checked' ){
						$show_title = 1;
					}else{
						$show_title = 0;
					}
					$forms[$x]['data']['show_title'] = $show_title;
					$admin_mailto = explode(',', $form['mailto'] );
					$forms[$x]['data']['admin_mailto'] = $admin_mailto;
					$forms[$x]['data']['user_subject'] = $form['subject'];
					$forms[$x]['data']['success_msg'] = $form['success_msg'];
					if( $form['send_email'] == 'checked' ){
						$send_email = 1;
					}else{
						$send_email = 0;
					}
					$forms[$x]['data']['send_email'] = $send_email;
					$forms[$x]['data']['landing_page'] = $form['landing_page'];
					$form['append_page'] = unserialize( $form['append_page'] );
					if( isset( $form['append_page'][0] ) ){
						$append_page = $form['append_page'][0];
					}else{
						$append_page = '';
					}
					$forms[$x]['data']['append_page'] = $append_page;
					$forms[$x]['data']['email_from'] = $form['email_from'];
					$forms[$x]['data']['user_email'] = $form['email_msg'];
					if( $form['multi'] == 'checked' ){
						$multi_part = 1;
					}else{
						$multi_part = 0;
					}
					$forms[$x]['data']['multi_part'] = $multi_part;
					if( $form['post'] == 'checked' ){
						$create_post = 1;
					}else{
						$create_post = 0;
					}
					$forms[$x]['data']['create_post'] = $create_post;
					$form['post_options'] = unserialize( $form['post_options'] );
					$forms[$x]['data']['post_logged_in'] = $form['post_options']['login'];
					$forms[$x]['data']['post_as'] = $form['post_options']['user'];
					$forms[$x]['data']['post_type'] = $form['post_options']['post_type'];
					$forms[$x]['data']['post_status'] = $form['post_options']['post_status'];
					if( $form['save_status'] == 'checked' ){
						$save_progress = 1;
					}else{
						$save_progress = 0;
					}

					$forms[$x]['data']['save_progress'] = $save_progress;
					$form['save_status_options'] = unserialize( $form['save_status_options'] );
					$forms[$x]['data']['clear_incomplete_saves'] = $form['save_status_options']['delete'];
					$forms[$x]['data']['save_msg'] = $form['save_status_options']['msg'];

					$form_fields = $wpdb->get_results("SELECT * FROM ".NINJA_FORMS_FIELDS_TABLE_NAME." WHERE form_id = ".$form_id, ARRAY_A );
					if( is_array( $form_fields ) AND !empty( $form_fields ) ){
						$y = 0;
						foreach( $form_fields as $field ){
							$unset = false;
							$field_type = $field['type'];
							$forms[$x]['field'][$y]['old_id'] = $field['id'];
							$forms[$x]['field'][$y]['form_id'] = $field['form_id'];
							$forms[$x]['field'][$y]['order'] = $field['field_order'];
							$forms[$x]['field'][$y]['data']['label'] = $field['label'];

							$field['extra'] = unserialize( $field['extra'] );

							if( isset( $field['value'] ) ){
								$default_value = $field['value'];
							}else{
								$default_value = '';
							}

							if( $default_value == 'none' ){
								$default_value = '';
							}


							switch( $field_type ){
								case 'textbox':
									$field_type = '_text';
									break;
								case 'list':
									$field_type = '_list';
									$forms[$x]['field'][$y]['data']['multi_size'] = 5;
									break;
								case 'checkbox':
									$field_type = '_checkbox';
									break;
								case 'textarea':
									$field_type = '_textarea';
									break;
								case 'hr':
									$field_type = '_hr';
									break;
								case 'heading':
									$default_value = $field['label'];
									$forms[$x]['field'][$y]['data']['label'] = 'Text';
									$field_type = '_desc';
									break;
								case 'spam':
									$field_type = '_spam';
									$forms[$x]['field'][$y]['data']['spam_answer'] = $default_value;
									break;
								case 'desc':
									$field_type = '_desc';
									break;
								case 'submit':
									$field_type = '_submit';
									break;
								case 'hidden':
									$field_type = '_hidden';
									break;
								case 'file':
									$field_type = '_upload';
									if( isset( $field['extra']['extra']['upload_types'] ) ){
										$forms[$x]['field'][$y]['data']['upload_types'] = $field['extra']['extra']['upload_types'];
									}
									if( isset( $field['extra']['extra']['upload_rename'] ) ){
										$forms[$x]['field'][$y]['data']['upload_rename'] = $field['extra']['extra']['upload_rename'];
									}
									if( isset( $field['extra']['extra']['email_attachment'] ) ){
										$forms[$x]['field'][$y]['data']['email_attachment'] = $field['extra']['extra']['email_attachment'];
									}
									$forms[$x]['field'][$y]['data']['upload_multi'] = 0;
									break;
								case 'divider':
									$field_type = '_page_divider';
									$forms[$x]['field'][$y]['data']['page_name'] = $field['label'];
									break;
								case 'progressbar':
									$forms[$x]['data']['mp_progress_bar'] = 1;
									$unset = true;
									break;
								case 'posttitle':
									$field_type = '_post_title';
									break;
								case 'postcontent':
									$field_type = '_post_content';
									break;
								case 'postcat':
									$field_type = '_post_category';
									break;
								case 'posttags':
									$field_type = '_post_tags';
									break;

							}

							$forms[$x]['field'][$y]['type'] = $field_type;

							$forms[$x]['field'][$y]['data']['default_value'] = $default_value;
							$forms[$x]['field'][$y]['data']['req'] = $field['req'];
							$forms[$x]['field'][$y]['data']['class'] = $field['class'];
							$forms[$x]['field'][$y]['data']['help_text'] = $field['help'];

							if( isset( $field['extra']['extra']['desc_cont'] ) ){
								$forms[$x]['field'][$y]['data']['desc_el'] = $field['extra']['extra']['desc_cont'];
							}
							if( isset( $field['extra']['extra']['label_pos'] ) ){
								$forms[$x]['field'][$y]['data']['label_pos'] = $field['extra']['extra']['label_pos'];
							}else{
								$forms[$x]['field'][$y]['data']['label_pos'] = 'left';
							}

							if( isset( $field['extra']['extra']['show_help'] ) ){
								if( $field['extra']['extra']['show_help'] == 'checked' ){
									$show_help = 1;
								}else{
									$show_help = 0;
								}
							}else{
								$show_help = 0;
							}

							$forms[$x]['field'][$y]['data']['show_help'] = $show_help;

							if( isset( $field['extra']['extra']['meta_key'] ) ){
								$forms[$x]['field'][$y]['data']['meta_value'] = $field['extra']['extra']['meta_key'];
							}
							if( isset( $field['extra']['extra']['rte'] ) ){
								if( $field['extra']['extra']['rte'] == 'checked' ){
									$textarea_rte = 1;
								}else{
									$textarea_rte = 0;
								}

								$forms[$x]['field'][$y]['data']['textarea_rte'] = $textarea_rte;
							}
							if( isset( $field['extra']['extra']['list_type'] ) ){
								$forms[$x]['field'][$y]['data']['list_type'] = $field['extra']['extra']['list_type'];
							}
							if( isset( $field['extra']['extra']['list_item'] ) AND is_array( $field['extra']['extra']['list_item'] ) ){
								$n = 0;
								foreach( $field['extra']['extra']['list_item'] as $item ){
									$forms[$x]['field'][$y]['data']['list']['options'][$n]['label'] = $item;
									$forms[$x]['field'][$y]['data']['list']['options'][$n]['value'] = $item;
									$n++;
								}
							}

							if( $unset ){
								unset( $forms[$x]['field'][$y] );
								$y--;
							}
							$y++;
						}
					}

					$sub_results = $wpdb->get_results( "SELECT * FROM ".NINJA_FORMS_SUBS_TABLE_NAME." WHERE `form_id` = ".$form_id, ARRAY_A );
					if( is_array( $sub_results ) AND !empty( $sub_results ) ){
						$i = 0;
						foreach( $sub_results as $sub ){

							if( $sub['sub_status'] == 'complete' ){
								$status = 1;
							}else{
								$status = 0;
							}
							$forms[$x]['subs'][$i]['status'] = $status;
							$forms[$x]['subs'][$i]['user_id'] = $sub['user_id'];

							if( $status == 0 ){
								$forms[$x]['subs'][$i]['action'] = 'save';
								if( isset( $sub['email'] ) ){
									$user = get_user_by( 'email', $sub['email'] );
									if( $user ){
										$forms[$x]['subs'][$i]['user_id'] = $user->ID;
									}else{
										$password = wp_generate_password( 12, true );
										$userdata = array(
											'user_login' => $sub['email'],
											'user_pass' => $password,
											'user_email' => $sub['email'],
											'role' => 'subscriber',
										);
										$user_id = wp_insert_user($userdata);
										$forms[$x]['subs'][$i]['user_id'] = $user_id;
										$blog_name = get_bloginfo( 'name' );
										$reg_subject = $blog_name.' '.__( 'Ninja Forms Password', 'ninja-forms' );
										$reg_msg = __( 'You are receiving this email because you have an incomplete form. Your username is now your email address and your password has been reset. It is now ', 'ninja-forms' );
										wp_mail( $sub['email'], $reg_subject, $reg_msg . $password );
									}
								}
							}else{
								$forms[$x]['subs'][$i]['action'] = 'submit';
							}


							$forms[$x]['subs'][$i]['form_id'] = $sub['form_id'];
							$forms[$x]['subs'][$i]['date_updated'] = $sub['date_updated'];

							$form_values = unserialize( $sub['form_values'] );
							if( is_array( $form_values ) AND !empty( $form_values ) ){
								$n = 0;
								foreach( $form_values as $data ){
									$user_value = $data['value'];
									foreach( $forms[$x]['field'] as $field ){
										if( $field['old_id'] == $data['id'] ){
											if( $field['type'] == '_upload' ){
												$user_value = array();
												$user_value[0]['user_file_name'] = $data['value'];
												$user_value[0]['file_name'] = $data['value'];
												$user_value[0]['file_path'] = '';
												$user_value[0]['file_url'] = '';
											}
										}
									}
									$forms[$x]['subs'][$i]['data'][$n]['old_id'] = $data['id'];
									$forms[$x]['subs'][$i]['data'][$n]['user_value'] = $user_value;
									$n++;
								}
							}
							$i++;
						}
					}
					$x++;
				}
			}
		}else{
			return false;
		}
	//}else{
		//return false;
	//}
	return $forms;
}