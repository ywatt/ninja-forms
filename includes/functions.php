<?php

function nf_get_settings(){
  $settings = get_option( 'ninja_forms_settings' );

  $settings['date_format']           = apply_filters( 'ninja_forms_labels/date_format'           , $settings['date_format'] );
  $settings['currency_symbol']       = apply_filters( 'ninja_forms_labels/currency_symbol'       , $settings['currency_symbol'] );
  $settings['req_div_label']         = apply_filters( 'ninja_forms_labels/req_div_label'         , $settings['req_div_label'] );
  $settings['req_field_symbol']      = apply_filters( 'ninja_forms_labels/req_field_symbol'      , $settings['req_field_symbol'] );
  $settings['req_error_label']       = apply_filters( 'ninja_forms_labels/req_error_label'       , $settings['req_error_label'] );
  $settings['req_field_error']       = apply_filters( 'ninja_forms_labels/req_field_error'       , $settings['req_field_error'] );
  $settings['spam_error']            = apply_filters( 'ninja_forms_labels/spam_error'            , $settings['spam_error'] );
  $settings['honeypot_error']        = apply_filters( 'ninja_forms_labels/honeypot_error'        , $settings['honeypot_error'] );
  $settings['timed_submit_error']    = apply_filters( 'ninja_forms_labels/timed_submit_error'    , $settings['timed_submit_error'] );
  $settings['javascript_error']      = apply_filters( 'ninja_forms_labels/javascript_error'      , $settings['javascript_error'] );
  $settings['invalid_email']         = apply_filters( 'ninja_forms_labels/invalid_email'         , $settings['invalid_email'] );
  $settings['process_label']         = apply_filters( 'ninja_forms_labels/process_label'         , $settings['process_label'] );
  $settings['login_link']            = apply_filters( 'ninja_forms_labels/login_link'            , $settings['login_link'] );
  $settings['username_label']        = apply_filters( 'ninja_forms_labels/username_label'        , $settings['username_label'] );
  $settings['reset_password']        = apply_filters( 'ninja_forms_labels/reset_password'        , $settings['reset_password'] );
  $settings['password_label']        = apply_filters( 'ninja_forms_labels/password_label'        , $settings['password_label'] );
  $settings['repassword_label']      = apply_filters( 'ninja_forms_labels/repassword_label'      , $settings['repassword_label'] );
  $settings['password_mismatch']     = apply_filters( 'ninja_forms_labels/password_mismatch'     , $settings['password_mismatch'] );
  $settings['login_button_label']    = apply_filters( 'ninja_forms_labels/login_button_label'    , $settings['login_button_label'] );
  $settings['cancel_button_label']   = apply_filters( 'ninja_forms_labels/cancel_button_label'   , $settings['cancel_button_label'] );
  $settings['login_error']           = apply_filters( 'ninja_forms_labels/login_error'           , $settings['login_error'] );
  $settings['register_link']         = apply_filters( 'ninja_forms_labels/register_link'         , $settings['register_link'] );
  $settings['email_label']           = apply_filters( 'ninja_forms_labels/email_label'           , $settings['email_label'] );
  $settings['register_button_label'] = apply_filters( 'ninja_forms_labels/register_button_label' , $settings['register_button_label'] );
  $settings['register_error']        = apply_filters( 'ninja_forms_labels/register_error'        , $settings['register_error'] );
  $settings['register_spam_q']       = apply_filters( 'ninja_forms_labels/register_spam_q'       , $settings['register_spam_q'] );
  $settings['register_spam_a']       = apply_filters( 'ninja_forms_labels/register_spam_a'       , $settings['register_spam_a'] );
  $settings['register_spam_error']   = apply_filters( 'ninja_forms_labels/register_spam_error'   , $settings['register_spam_error'] );

  return apply_filters( "ninja_forms_settings",  $settings );
} // nf_get_settings

function ninja_forms_return_echo($function_name){
	$arguments = func_get_args();
    array_shift($arguments); // We need to remove the first arg ($function_name)
    ob_start();
    call_user_func_array($function_name, $arguments);
	$return = ob_get_clean();
	return $return;
}

function ninja_forms_random_string($length = 10){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random_string;
}

function ninja_forms_remove_from_array($arr, $key, $val, $within = FALSE) {
    foreach ($arr as $i => $array)
            if ($within && stripos($array[$key], $val) !== FALSE && (gettype($val) === gettype($array[$key])))
                unset($arr[$i]);
            elseif ($array[$key] === $val)
                unset($arr[$i]);

    return array_values($arr);
}

function ninja_forms_letters_to_numbers( $size ) {
	$l		= substr( $size, -1 );
	$ret	= substr( $size, 0, -1 );
	switch( strtoupper( $l ) ) {
		case 'P':
			$ret *= 1024;
		case 'T':
			$ret *= 1024;
		case 'G':
			$ret *= 1024;
		case 'M':
			$ret *= 1024;
		case 'K':
			$ret *= 1024;
	}
	return $ret;
}