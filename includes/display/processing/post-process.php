<?php
function ninja_forms_post_process(){
	global $wpdb, $ninja_forms_processing;

	$ajax = $ninja_forms_processing->get_form_setting('ajax');
	$form_id = $ninja_forms_processing->get_form_ID();

	if(!$ninja_forms_processing->get_all_errors()){

		do_action('ninja_forms_post_process');

		if( !$ninja_forms_processing->get_all_errors() ){

			$ninja_forms_processing->update_form_setting( 'processing_complete', 1 );
			$success = $ninja_forms_processing->get_form_setting( 'success_msg' );

			$ninja_forms_processing->add_success_msg( 'success_msg', $success );

			$json = ninja_forms_json_response();

			if($ajax == 1){
				//header('Content-Type', 'application/json');
				echo $json;
				die();
			}else{

				if( $ninja_forms_processing->get_form_setting( 'landing_page' ) != '' ){
					// Setup our $_SESSION variables

					$_SESSION['ninja_forms_form_id'] = $form_id;
					$_SESSION['ninja_forms_values'] = $ninja_forms_processing->get_all_fields();
					$_SESSION['ninja_forms_form_settings'] = $ninja_forms_processing->get_all_form_settings();
					$all_fields_settings = array();
					foreach ( $ninja_forms_processing->get_all_fields() as $field_id => $user_value ) {
						$field_settings = $ninja_forms_processing->get_field_settings( $field_id );
						$all_fields_settings[$field_id] = $field_settings; 
					}
					$_SESSION['ninja_forms_fields_settings'] = $all_fields_settings;

					// Set errors and success messages as $_SESSION variables.
					$success = $ninja_forms_processing->get_all_success_msgs();
					$errors = $ninja_forms_processing->get_all_errors();

					$_SESSION['ninja_forms_success_msgs'] = $success;
					$_SESSION['ninja_forms_error_msgs'] = $errors;

					header( 'Location: '.$ninja_forms_processing->get_form_setting( 'landing_page' ) );
					die();
				}
			}
		}else{
			if($ajax == 1){
				//header('Content-Type', 'application/json');
				echo $json;
				die();
			}else{
				//echo 'post-processing';
				//print_r($ninja_forms_processing->get_all_errors());
			}
		}
	}else{
		if($ajax == 1){
			//header('Content-Type', 'application/json');
			echo $json;
			die();
		}else{
			//echo 'post-processing';
			//print_r($ninja_forms_processing->get_all_errors());
		}
	}
}