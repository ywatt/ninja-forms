<?php

function nf_tmp_frontend( $atts = array() ) {
	Ninja_Forms()->display( $atts['form_id'] );
}

add_shortcode( 'nf_tmp_frontend', 'nf_tmp_frontend' );