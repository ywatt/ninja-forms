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

function ninja_forms_admin_body_filter( $classes ) {
  global $pagenow;

  if ( $pagenow == 'admin.php' and isset ( $_REQUEST['page'] ) ) {
    switch( $_REQUEST['page'] ) {
      case 'ninja-forms':
        $classes .= ' ninja-forms';
        $classes .= ' ninja-forms-forms';
        break;
      case 'ninja-forms-edit':
        $classes .= ' ninja-forms';
        $classes .= ' ninja-forms-edit';
        break;
      case 'ninja-forms-settings':
        $classes .= ' ninja-forms';
        $classes .= ' ninja-forms-settings';
        break;

    }

  }
  return $classes;
}

add_filter( 'admin_body_class', 'ninja_forms_admin_body_filter' );

function ninja_forms_get_current_tab(){
  global $ninja_forms_tabs;
  if(isset($_REQUEST['page'])){
    $current_page = $_REQUEST['page'];


    if(isset($_REQUEST['tab'])){
      $current_tab = $_REQUEST['tab'];
    }else{
      if(isset($ninja_forms_tabs[$current_page]) AND is_array($ninja_forms_tabs[$current_page])){
        $first_tab = array_slice($ninja_forms_tabs[$current_page], 0, 1);
        foreach($first_tab as $key => $val){
          $current_tab = $key;
        }
      }else{
        $current_tab = '';
      }
    }
    return $current_tab;
  }else{
    return false;
  }
}

function ninja_forms_date_to_datepicker($date){
  $pattern = array(

    //day
    'd',    //day of the month
    'j',    //3 letter name of the day
    'l',    //full name of the day
    'z',    //day of the year

    //month
    'F',    //Month name full
    'M',    //Month name short
    'n',    //numeric month no leading zeros
    'm',    //numeric month leading zeros

    //year
    'Y',    //full numeric year
    'y'   //numeric year: 2 digit
  );
  $replace = array(
    'dd','d','DD','o',
    'MM','M','m','mm',
    'yy','y'
  );
  foreach($pattern as &$p)  {
    $p = '/'.$p.'/';
  }
  return preg_replace($pattern,$replace,$date);
}

function str_putcsv($array, $delimiter = ',', $enclosure = '"', $terminator = "\n") {
  # First convert associative array to numeric indexed array
  foreach ($array as $key => $value) $workArray[] = $value;

  $returnString = '';                 # Initialize return string
  $arraySize = count($workArray);     # Get size of array

  for ($i=0; $i<$arraySize; $i++) {
    # Nested array, process nest item
    if (is_array($workArray[$i])) {
      $returnString .= str_putcsv($workArray[$i], $delimiter, $enclosure, $terminator);
    } else {
      switch (gettype($workArray[$i])) {
        # Manually set some strings
        case "NULL":     $_spFormat = ''; break;
        case "boolean":  $_spFormat = ($workArray[$i] == true) ? 'true': 'false'; break;
        # Make sure sprintf has a good datatype to work with
        case "integer":  $_spFormat = '%i'; break;
        case "double":   $_spFormat = '%0.2f'; break;
        case "string":   $_spFormat = '%s'; $workArray[$i] = str_replace("$enclosure", "$enclosure$enclosure", $workArray[$i]); break;
        # Unknown or invalid items for a csv - note: the datatype of array is already handled above, assuming the data is nested
        case "object":
        case "resource":
        default:         $_spFormat = ''; break;
      }
              $returnString .= sprintf('%2$s'.$_spFormat.'%2$s', $workArray[$i], $enclosure);
        $returnString .= ($i < ($arraySize-1)) ? $delimiter : $terminator;
    }
  }
  # Done the workload, return the output information
  return $returnString;
}