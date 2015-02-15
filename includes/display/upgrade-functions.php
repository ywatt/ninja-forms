<?php
/**
 * Update form settings to the new storage system when the form is viewed for the first time.
 *
 * @since 2.9
 * @return void
 */
function nf_29_update_form_settings( $form_id ) {
	global $wpdb;

	// Check to see if an object exists with our form id.
	$type = nf_get_object_type( $form_id );
	if ( $type && 'form' != $type ) {
		// We have an object with our form id.
		// Insert a new object.
		$next_id = nf_insert_object( $type );
		
		// Replace all instances of the object ID with our new one.
		$wpdb->update( NF_OBJECT_META_TABLE_NAME, array( 'object_id' => $next_id ), array( 'object_id' => $form_id ) );
		$wpdb->update( NF_OBJECT_RELATIONSHIPS_TABLE_NAME, array( 'parent_id' => $next_id ), array( 'parent_type' => $type, 'parent_id' => $form_id ) );
		$wpdb->update( NF_OBJECT_RELATIONSHIPS_TABLE_NAME, array( 'child_id' => $next_id ), array( 'child_type' => $type, 'child_id' => $form_id ) );
	
		// Delete the original object
		$wpdb->query( 'DELETE FROM ' . NF_OBJECTS_TABLE_NAME . ' WHERE id = ' . $form_id );
	}

	$form = $wpdb->get_row( 'SELECT * FROM ' . NINJA_FORMS_TABLE_NAME . ' WHERE id = ' . $form_id, ARRAY_A );
	$settings = maybe_unserialize( $form['data'] );
	$settings['date_updated'] = $form['date_updated'];
	$f_id = nf_insert_object( 'form', $form['id'] );
	foreach ( $settings as $meta_key => $value ) {
		nf_update_object_meta( $f_id, $meta_key, $value );
	}
	$wpdb->query( 'DELETE FROM ' . NINJA_FORMS_TABLE_NAME . ' WHERE id = ' . $f_id );
}

/**
 * Check our option to see if we've updated all of our form settings.
 * If we haven't, then update the form currently being viewed.
 * 
 * @since 2.9
 * @return void
 */
function nf_29_update_form_settings_check( $form_id ) {
	nf_29_update_form_settings( $form_id );
}

add_action( 'nf_before_display_loading', 'nf_29_update_form_settings_check' );