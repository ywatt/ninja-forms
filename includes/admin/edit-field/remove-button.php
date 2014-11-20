<?php
add_action( 'ninja_forms_edit_field_before_closing_li', 'ninja_forms_edit_field_remove_button' );
function ninja_forms_edit_field_remove_button( $field_id ){
	$current_tab = ninja_forms_get_current_tab();
	if ( isset ( $_REQUEST['page'] ) ) {
		$current_page = esc_html( $_REQUEST['page'] );
	} else {
		$current_page = '';
	}

	$plugin_settings = nf_get_settings();
	
	$slug = 'field_'.$field_id;
	if ( isset ( $plugin_settings['metabox_state'][$current_page][$current_tab][$slug] ) && ! empty ( $plugin_settings['metabox_state'][$current_page][$current_tab][$slug] ) ) {
		$metabox_state = 1;
	} else {
		$metabox_state = 0;
	}

	if ( $metabox_state == 1 ) {
		?>
		<div class="menu-item-actions description-wide submitbox">
			<a class="submitdelete deletion ninja-forms-field-remove" id="ninja_forms_field_<?php echo $field_id;?>_remove" name="" href="#"><?php _e('Remove', 'ninja-forms'); ?></a>
		</div>
		<?php		
	}
}
