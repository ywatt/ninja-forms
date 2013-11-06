<?php

function ninja_forms_replyto_change() {
	if ( $_REQUEST['page'] == 'ninja-forms' AND $_REQUEST['tab'] == 'field_settings' ) {
		$form_id = $_REQUEST['form_id'];
		$fields = ninja_forms_get_fields_by_form_id( $form_id );
		foreach ($fields as $field) {
			if ( $field['type'] = '_text' ) {
				if ( isset( $field['data']['from_email'] ) AND $field['data']['from_email'] == 1 ) {
					$field['data']['replyto_email'] = 1;
					unset( $field['data']['from_email'] );
					$change_required = true;
				} elseif ( isset( $field['data']['from_email'] ) AND $field['data']['from_email'] == 0 ) {
					$field['data']['replyto_email'] = 0;
					unset( $field['data']['from_email'] );
					$change_required = true;
				}
				if ( $change_required ) {
					$data = serialize( $field['data'] );
					$args = array(
						'update_array' => array(
							'data' => $data,
						),
						'where' => array(
							'id' => $field['id'],
						),
					);
					ninja_forms_update_field( $args );
				}
			}
		}
	}
}
add_action( 'admin_init', 'ninja_forms_replyto_change' );