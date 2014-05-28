<?php

/**
 * Acts as a wrapper/alias for nf_get_objects_by_type.
 * 
 * @since 3.0
 * @return array $forms
 */

function nf_get_all_forms() {
	return nf_get_objects_by_type( 'form' );
}

/**
 * Gets our forms by type.
 * 
 * @since 3.0
 * @return array $tmp_array
 */

function nf_get_forms_by_type( $type ) {
	$forms = nf_get_all_forms();
	$tmp_array = array();
	foreach( $forms as $form ) {
		$form_type = nf_get_form_setting( $form['id'], 'type' );
		if ( $form_type == $type ) {
			$tmp_array[] = $form['id'];
		}
	}
	return $tmp_array;
}

/**
 * Acts as a wrapper/alias for nf_get_object_children that is specific to notifications.
 * 
 * @since 3.0
 * @param string $form_id
 * @return array $notifications
 */

function nf_get_notifications_by_form_id( $form_id, $full_data = true ) {
	return nf_get_object_children( $form_id, 'notification', $full_data );
}

/**
 * Acts as a wrapper/alias for nf_get_object_children that is specific to fields
 * 
 * @since 3.0
 * @param string $form_id
 * @return array $fields
 */

function nf_get_fields_by_form_id( $form_id, $full_data = true ) {
	return nf_get_object_children( $form_id, 'field', $full_data );
}

/**
 * Delete a form field.
 * Acts as a wrapper/alias for nf_delete_object
 * 
 * @since 3.0
 * @param int $field_id
 * @return bool true
 */
function nf_delete_field( $field_id ) {
	return nf_delete_object( $field_id );
}

/**
 * Acts as a wrapper/alias for nf_get_object_meta
 *
 * @since 3.0
 * @param string $id
 * @return array $notification
 */

function nf_get_notification_by_id( $notification_id ) {
	return nf_get_object_meta( $notification_id );
}

/**
 * Acts as a wrapper/alias for nf_get_object_meta
 *
 * @since 3.0
 * @param string $form_id
 * @return array $settings
 */

function nf_get_form_settings( $form_id ) {
	return nf_get_object_meta( $form_id );
}

/**
 * Acts as a wrapper/alias for nf_get_object_meta_value.
 * 
 * @since 3.0
 * @param string $form_id
 * @param string $form_setting
 * @return var $form_value
 */

function nf_get_form_setting( $form_id, $form_setting ) {
	return nf_get_object_meta_value( $form_id, $form_setting );
}

/**
 * Get a field's type from its id
 * 
 * @since 3.0
 * @param int $field_id
 * @return string $type
 */
function nf_get_field_type( $field_id ) {
	return nf_get_object_meta_value( $field_id, 'type' );
}

/**
 * Get a count of submissions for a form
 * 
 * @since 3.0
 * @param int $post_id
 * @return int $count
 */
 function nf_get_sub_count( $form_id, $post_status = 'publish' ) {
 	$args = array(
	    'meta_key' => 'form_id',
	    'meta_value' => $form_id,
	    'post_type' => 'nf_sub',
	    'posts_per_page' => 999999,
	    'post_status' => $post_status,
	);
	$posts = get_posts( $args );

	return count( $posts );
 }

/**
 * Insert a form. Accepts an array of meta.
 * Uses both nf_insert_object() and nf_update_object_meta();
 * 
 * @since 3.0
 * @param array $object_meta
 * @return int $form_id
 */

function nf_insert_form( $object_meta = array() ) {

	// Insert a new object
	$form_id = nf_insert_object( 'form' );

	// Loop through our object meta array and insert the elements.
	if ( ! empty( $object_meta ) ) {
		foreach( $object_meta as $key => $value ) {
			// Add our objectmeta.
			nf_update_object_meta( $form_id, $key, $value );
		}
	}

	return $form_id;
}

/**
 * Function that gets all objects of a given type.
 * 
 * @since 3.0
 * @return array $results
 */

function nf_get_objects_by_type( $object_type ) {
	global $wpdb;

	// Bail if we don't have an object type.
	if ( $object_type == '' )
		return false;

	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . NF_OBJECTS_TABLE_NAME . " WHERE type = %s", $object_type ), ARRAY_A );

	return $results;
}

/**
 * Function that gets children objects by type and parent id
 * 
 * @since 3.0
 * @param string $parent_id
 * @param string $type
 * @return array $children
 */

function nf_get_object_children( $object_id, $child_type = '', $full_data = true ) {
	global $wpdb;

	if ( $child_type != '' ) {
		$children = $wpdb->get_results( $wpdb->prepare( "SELECT child_id FROM " . NF_RELATIONSHIPS_TABLE_NAME . " WHERE child_type = %s AND parent_id = %d", $child_type, $object_id ), ARRAY_A);
	} else {
		$children = $wpdb->get_results( $wpdb->prepare( "SELECT child_id FROM " . NF_RELATIONSHIPS_TABLE_NAME . " WHERE parent_id = %d", $object_id ), ARRAY_A);
	}
	$tmp_array = array();
	if ( $full_data ) {
		foreach( $children as $id ) {
			$child_id = $id['child_id'];
			$settings = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM " . NF_META_TABLE_NAME . " WHERE object_id = %d", $child_id ), ARRAY_A);
			if ( ! empty( $settings ) ) {
				foreach ( $settings as $s ) {
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
 * @since 3.0
 * @param string $object
 * @return array $settings
 */

function nf_get_object_meta( $object_id ) {
	global $wpdb;

	$tmp_array = array();
	$settings = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . NF_META_TABLE_NAME . ' WHERE object_id = %d', $object_id ), ARRAY_A);

	if ( is_array( $settings ) ) {
		foreach( $settings as $setting ) {
			$tmp_array[ $setting['meta_key'] ] = $setting['meta_value'];
		}
	}

	return $tmp_array;
}

/**
 * Function that retrieves an object. Returns the object type.
 * 
 * @since 3.0
 * @param int $object_id
 * @return string $object_type
 */

function nf_get_object_type( $object_id ) {
	global $wpdb;

	$row = $wpdb->get_row( $wpdb->prepare( 'SELECT type FROM ' . NF_OBJECTS_TABLE_NAME . ' WHERE id = %d', $object_id ), ARRAY_A );

	return $row['type'];
}

/**
 * Function that gets a piece of object meta
 * 
 * @since 3.0
 * @param string $object_id
 * @param string $meta_key
 * @return var $meta_value
 */

function nf_get_object_meta_value( $object_id, $meta_key ) {
	global $wpdb;

	$meta_value = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM ".NF_META_TABLE_NAME." WHERE object_id = %d AND meta_key = %s", $object_id, $meta_key ), ARRAY_A );

	return $meta_value['meta_value'];
}

/**
 * Function that updates a piece of object meta
 *
 * @since 3.0
 * @param string $object_id
 * @param string $meta_key
 * @param string $meta_value
 * @return string $meta_id
 */

function nf_update_object_meta( $object_id, $meta_key, $meta_value ) {
	global $wpdb;

	// Check to see if this meta_key/meta_value pair exist for this object_id.
	$found = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM ".NF_META_TABLE_NAME." WHERE object_id = %d AND meta_key = %s", $object_id, $meta_key ), ARRAY_A );

	if ( $found ) {
		$wpdb->prepare( $wpdb->update( NF_META_TABLE_NAME, array( 'meta_value' => $meta_value ), array( 'meta_key' => $meta_key, 'object_id' => $object_id ) ), NULL );
		$meta_id = $found['id'];
	} else {
		$wpdb->insert( NF_META_TABLE_NAME, array( 'object_id' => $object_id, 'meta_key' => $meta_key, 'meta_value' => $meta_value ) );
		$meta_id = $wpdb->insert_id;
	}

	return $meta_id;
}

/**
 * Delete an object. Also removes all of the objectmeta attached to the object and any references to it in the relationship table.
 *
 * @since 3.0
 * @param int $object_id
 * @return bool
 */

function nf_delete_object( $object_id ) {
	global $wpdb;

	// Delete this object.
	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . NF_OBJECTS_TABLE_NAME .' WHERE id = %d', $object_id ) );

	// Delete any objectmeta attached to this object.
	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . NF_META_TABLE_NAME .' WHERE object_id = %d', $object_id ) );

	// Delete any references to this object in the relationship table
	$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . NF_RELATIONSHIPS_TABLE_NAME .' WHERE child_id = %d OR parent_id = %d', $object_id, $object_id ) );

	return true;
}

/**
 * Insert an object.
 * 
 * @since 3.0
 * @param string $type
 * @return int $object_id
 */

function nf_insert_object( $type ) {
	global $wpdb;
	$wpdb->insert( NF_OBJECTS_TABLE_NAME, array( 'type' => $type ) );
	return $wpdb->insert_id;
}

/**
 * Create a relationship between two objects
 * 
 * @since 3.0
 * @param int $child_id
 * @param string child_type
 * @param int $parent_id
 * @param string $parent_type
 * @return bool
 */

function nf_add_relationship( $child_id, $child_type, $parent_id, $parent_type ) {
	global $wpdb;
	// Make sure that our relationship doesn't already exist.
	$count = $wpdb->query( $wpdb->prepare( 'SELECT id FROM '. NF_RELATIONSHIPS_TABLE_NAME .' WHERE child_id = %d AND parent_id = %d', $child_id, $parent_id ), ARRAY_A );
	if ( empty( $count ) ) {
		$wpdb->insert( NF_RELATIONSHIPS_TABLE_NAME, array( 'child_id' => $child_id, 'child_type' => $child_type, 'parent_id' => $parent_id, 'parent_type' => $parent_type ) );
	}
}