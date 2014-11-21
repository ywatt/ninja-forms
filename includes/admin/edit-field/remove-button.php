<?php
add_action( 'ninja_forms_edit_field_after_registered', 'ninja_forms_edit_field_remove_button', 99999 );
function ninja_forms_edit_field_remove_button( $field_id ){
	?>
	<div class="menu-item-actions description-wide submitbox">
		<a class="submitdelete deletion ninja-forms-field-remove" id="ninja_forms_field_<?php echo $field_id;?>_remove" name="" href="#"><?php _e('Remove', 'ninja-forms'); ?></a>
	</div>
	<?php		
}
