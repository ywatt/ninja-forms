<?php

/**
 * Make sure that our honeypot wasn't filled in.
 */
function nf_check_honeypot() {
	global $ninja_forms_processing;

	if ( $ninja_forms_processing->get_extra_value( '_honeypot' ) != '' ) {
		$plugin_settings = Ninja_Forms()->get_plugin_settings();
		$honeypot_error = __( $plugin_settings['honeypot_error'], 'ninja-forms' );
		$ninja_forms_processing->add_error( 'honeypot', $honeypot_error );
	}
}

add_action( 'ninja_forms_pre_process', 'nf_check_honeypot', 8 );