<?php

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

function ninja_forms_subval_sort( $a, $subkey ) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	if ( is_array ( $b ) ) {
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return $c;		
	} else {
		return $a;
	}

}

/**
 * Return the begin date with an added 00:00:00.
 * Checks for the current date format setting and tries to respect it.
 * 
 * @since 2.7
 * @param string $begin_date
 * @return string $begin_date
 */
function nf_get_begin_date( $begin_date ) {
	$plugin_settings = nf_get_settings();

	if ( isset ( $plugin_settings['date_format'] ) ) {
		$date_format = $plugin_settings['date_format'];
	} else {
		$date_format = 'm/d/Y';
	}

	if ( $date_format == 'd/m/Y' ) {
		$begin_date = str_replace( '/', '-', $begin_date );
	} else if ( $date_format == 'm-d-Y' ) {
		$begin_date = str_replace( '-', '/', $begin_date );
	}
	$begin_date .= '00:00:00';
	$begin_date = new DateTime( $begin_date );

	return $begin_date;
}

/**
 * Return the end date with an added 23:59:59.
 * Checks for the current date format setting and tries to respect it.
 * 
 * @since 2.7
 * @param string $end_date
 * @return string $end_date
 */
function nf_get_end_date( $end_date ) {
	$plugin_settings = nf_get_settings();

	if ( isset ( $plugin_settings['date_format'] ) ) {
		$date_format = $plugin_settings['date_format'];
	} else {
		$date_format = 'm/d/Y';
	}

	if ( $date_format == 'd/m/Y' ) {
		$end_date = str_replace( '/', '-', $end_date );
	} else if ( $date_format == 'm-d-Y' ) {
		$end_date = str_replace( '-', '/', $end_date );
	}
	$end_date .= '23:59:59';
	$end_date = new DateTime( $end_date );

	return $end_date;
}

/**
 * Checks whether function is disabled.
 *
 * @since 2.7
 *
 * @param string  $function Name of the function.
 * @return bool Whether or not function is disabled.
 */
function nf_is_func_disabled( $function ) {
	$disabled = explode( ',',  ini_get( 'disable_functions' ) );

	return in_array( $function, $disabled );
}

/**
 * Acts as a wrapper/alias for nf_get_object_children that is specific to notifications.
 * 
 * @since 2.8
 * @param string $form_id
 * @return array $notifications
 */

function nf_get_notifications_by_form_id( $form_id, $full_data = true ) {
	return nf_get_object_children( $form_id, 'notification', $full_data );
}

/**
 * Acts as a wrapper/alias for nf_get_object_meta
 *
 * @since 2.8
 * @param string $id
 * @return array $notification
 */

function nf_get_notification_by_id( $notification_id ) {
	return nf_get_object_meta( $notification_id );
}

/**
 * Function that gets a piece of object meta
 * 
 * @since 2.8
 * @param string $object_id
 * @param string $meta_key
 * @return var $meta_value
 */

function nf_get_object_meta_value( $object_id, $meta_key ) {
	global $wpdb;

	$meta_value = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM ".NF_OBJECT_META_TABLE_NAME." WHERE object_id = %d AND meta_key = %s", $object_id, $meta_key ), ARRAY_A );
	if ( is_array ( $meta_value['meta_value'] ) ) {
		$meta_value['meta_value'] = unserialize(  $meta_value['meta_value'] );
	}

	return $meta_value['meta_value'];
}


/**
 * Function that gets children objects by type and parent id
 * 
 * @since 2.8
 * @param string $parent_id
 * @param string $type
 * @return array $children
 */

function nf_get_object_children( $object_id, $child_type = '', $full_data = true ) {
	global $wpdb;

	if ( $child_type != '' ) {
		$children = $wpdb->get_results( $wpdb->prepare( "SELECT child_id FROM " . NF_OBJECT_RELATIONSHIPS_TABLE_NAME . " WHERE child_type = %s AND parent_id = %d", $child_type, $object_id ), ARRAY_A);
	} else {
		$children = $wpdb->get_results( $wpdb->prepare( "SELECT child_id FROM " . NF_OBJECT_RELATIONSHIPS_TABLE_NAME . " WHERE parent_id = %d", $object_id ), ARRAY_A);
	}
	$tmp_array = array();
	if ( $full_data ) {
		foreach( $children as $id ) {
			$child_id = $id['child_id'];
			$settings = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM " . NF_OBJECT_META_TABLE_NAME . " WHERE object_id = %d", $child_id ), ARRAY_A);
			if ( ! empty( $settings ) ) {
				foreach ( $settings as $s ) {
					if ( is_array ( $s['meta_value'] ) ) {
						$s['meta_value'] =  unserialize( $s['meta_value'] );
					}
					$tmp_array[ $child_id ][ $s['meta_key'] ] = $s['meta_value'];
				}				
			} else {
				$tmp_array[ $child_id ] = array();
			}
		}

			
	} else {
		if ( is_array( $children ) ) {
			foreach ( $children as $child ) {
				$tmp_array[] = $child['child_id'];
			}
		}
	}

	return $tmp_array;
}


/**
 * Function that gets all the meta values attached to a given object.
 *
 * @since 2.8
 * @param string $object
 * @return array $settings
 */
function nf_get_object_meta( $object_id ) {
	global $wpdb;

	$tmp_array = array();
	$settings = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . NF_OBJECT_META_TABLE_NAME . ' WHERE object_id = %d', $object_id ), ARRAY_A);

	if ( is_array( $settings ) ) {
		foreach( $settings as $setting ) {
			if ( is_serialized ( $setting['meta_value'] ) ) {
				$setting['meta_value'] = unserialize( $setting['meta_value'] );
			}
			$tmp_array[ $setting['meta_key'] ] = $setting['meta_value'];
		}
	}

	return $tmp_array;
}