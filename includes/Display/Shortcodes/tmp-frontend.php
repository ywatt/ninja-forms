<?php

function nf_tmp_frontend( $atts = array() ) {
	return 'HELLO WORLD!';
}

add_shortcode( 'nf_tmp_frontend', 'nf_tmp_frontend' );