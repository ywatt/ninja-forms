<?php

function nf_tmp_frontend( $atts = array() ) {
	Ninja_Forms()->display( $atts['form_id'] );
}

add_shortcode( 'nf_tmp_frontend', 'nf_tmp_frontend' );

add_action( 'wp_footer', 'nf_test_ajax', 9001 );

function nf_test_ajax()
{

	?>
	<script>
		jQuery(document).ready(function($) {
//			var ajaxurl = '<?php //echo admin_url( 'admin-ajax.php' ); ?>//';
//			var data = {
//				action: 'nf_process_submission',
//				nf_form: form_1
//			}

			console.log( nfForms );

//			jQuery.post(ajaxurl, data, function (response) {
//
//				response = JSON.parse( response );
//
//				console.log( response );
//
//			});
		});
	</script>
	<?php
}
