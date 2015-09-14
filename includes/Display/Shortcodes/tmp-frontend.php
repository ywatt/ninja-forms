<?php

function nf_tmp_frontend( $atts = array() ) {
	new NF_Display_Render();
}

add_shortcode( 'nf_tmp_frontend', 'nf_tmp_frontend' );