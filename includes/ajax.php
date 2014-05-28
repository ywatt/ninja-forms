<?php

function nf_delete_field_ajax(){
	echo $_REQUEST['field_id'];
	die();
}

add_action( 'wp_ajax_nf_delete_field', 'nf_delete_field_ajax' );