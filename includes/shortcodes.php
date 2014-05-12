<?php

/**
 * Display shortcode
 *
 * @since 3.0
 * @return string
 */
function nf_display_shortcode( $atts, $content = null ) {
	// Bail if we don't get a form id.
	if ( ! isset ( $atts['id'] ) )
		return $content;

	$form_id = $atts['id'];
	ob_start();
	Ninja_Forms()->form( $form_id )->render();
	return ob_get_clean();
}

add_shortcode( 'ninja_form', 'nf_display_shortcode' );