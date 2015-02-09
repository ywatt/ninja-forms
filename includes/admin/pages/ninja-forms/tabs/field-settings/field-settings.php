<?php

function ninja_forms_register_tab_field_settings(){
	if(isset($_REQUEST['form_id'])){
		$form_id = absint( $_REQUEST['form_id'] );
	}else{
		$form_id = '';
	}

	$args = array(
		'name' => __( 'Build Your Form', 'ninja-forms' ),
		'page' => 'ninja-forms',
		'display_function' => 'ninja_forms_tab_field_settings',
		'disable_no_form_id' => true,
		'show_save' => false,
		'tab_reload' => false,
	);
	ninja_forms_register_tab( 'builder', $args );
}

add_action('admin_init', 'ninja_forms_register_tab_field_settings');

function ninja_forms_tab_field_settings(){
	global $wpdb;

	if ( isset ( $_REQUEST['form_id'] ) ) {
		$form_id = absint( $_REQUEST['form_id'] );
	} else {
		$form_id = '';
	}

	if ( ! empty ( $form_id ) && 'new' != $form_id ) {
		do_action( 'ninja_forms_edit_field_before_ul', $form_id );
		do_action( 'ninja_forms_edit_field_ul', $form_id );
		do_action( 'ninja_forms_edit_field_after_ul', $form_id );
	}

	?>
<!-- 
</form>
<div id="nf-link-backdrop" style="display: block;"></div>
<div id="nf-link-wrap" class="wp-core-ui" style="display: block;">
	<form id="nf-link" tabindex="-1">
		<div id="link-modal-title">
			Save Your Form			<button type="button" id="nf-link-close"><span class="screen-reader-text">Close</span></button>
	 	</div>
	 	<div id="modal-contents-wrapper" style="padding:20px;">
			<div id="link-selector">
				<div id="link-options">
					<div>
						<label><input id="form_title" class="widefat" style="width:100%;" type="text" name="linktitle" placeholder="Give your form a title. This is how you'll find the form later."></label>
					</div>
				</div>
				<div id="link-optionss">
					<div class="link-target">
						<label><span>&nbsp;</span><input type="checkbox" id="link-target-checkbox"> Insert Submit Button</label>
					</div>
				</div>
			</div>
			<div class="submitbox">
				<div id="nf-link-cancel">
					<a class="submitdelete deletion" href="#">Cancel</a>
				</div>
				<div id="nf-link-update">
					<input type="submit" value="Save" class="button button-secondary" id="nf-link-submit" name="nf-link-submit" disabled>
				</div>
			</div>
		</div>
		</form>
		</div> -->


	<?php
}

/**
 * Listen for a new form action and create one if necessary.
 * 
 * @since 2.9
 * @return void
 */
function nf_create_form_listen() {
	$page = isset ( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';
	$tab = isset ( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : '';
	$form_id = isset ( $_REQUEST['form_id'] ) ? $_REQUEST['form_id'] : '';

	if ( 'ninja-forms' == $page && 'builder' == $tab && 'new' == $form_id ) {
		$form_id = Ninja_Forms()->form()->create();
		$redirect = add_query_arg( array( 'form_id' => $form_id ) );
		wp_redirect( $redirect );
		die();		
	}
}

add_action( 'admin_init', 'nf_create_form_listen', 5 );