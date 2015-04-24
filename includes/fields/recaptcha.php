<?php if ( ! defined( 'ABSPATH' ) ) exit;
function ninja_forms_register_field_recaptcha() {
	$args = array(
		'name' => __( 'reCAPTCHA', 'ninja-forms' ),
		'sidebar' => 'template_fields',
		'edit_function' => '',
		'display_function' => 'ninja_forms_field_recaptcha_display',
		'save_function' => '',
		'group' => 'standard_fields',
		'default_label' => __( 'Confirm that you are not a bot', 'ninja-forms' ),
		'edit_label' => true,
		'req' => true,
		'edit_label_pos' => true,
		'edit_req' => false,
		'edit_custom_class' => false,
		'edit_help' => false,
		'edit_meta' => false,
		'sidebar' => 'template_fields',
		'edit_conditional' => false,
		'display_label' => true,
		'process_field' => false,
		'pre_process' => 'ninja_forms_field_recaptcha_pre_process',

	);

	ninja_forms_register_field( '_recaptcha', $args );
}

add_action( 'init', 'ninja_forms_register_field_recaptcha' );

function ninja_forms_field_recaptcha_display( $field_id, $data, $form_id = '' ) {
	$settings = get_option( "ninja_forms_settings" );
	$lang = $settings['recaptcha_lang'];
	$siteKey = $settings['recaptcha_site_key'];
	if ( !empty( $siteKey ) ) { ?>

		<div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>"> </script>

		<?php
	}
}

function ninja_forms_field_recaptcha_pre_process( $field_id, $user_value  ) {
	global $ninja_forms_processing;

	if ( empty( $_POST['g-recaptcha-response'] ) ) {
		$ninja_forms_processing->add_error( 'error_recaptcha', __( 'Please enter value in captcha field' , 'ninja-forms' ) );
	}else {
		$settings = get_option( 'ninja_forms_settings' );
		$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$settings['recaptcha_secret_key'].'&response='.$_POST['g-recaptcha-response'];
		$resp = wp_remote_get( $url, array( 'sslverify'=>true ) );

		if ( !is_wp_error( $resp ) ) {
			$body = wp_remote_retrieve_body( $resp );
			$response = json_decode( $body );
			if ( $response->success===false ) {
				if ( !empty( $response->{'error-codes'} ) && $response->{'error-codes'} != 'missing-input-response' ) {
					$error= __( 'Please check if you have entered Site & Secret key correctly', 'ninja-forms' );
				}else {
					$error= __( 'Captcha mismatch, Please enter correct value in captcha field', 'ninja-forms' );
				}
				$ninja_forms_processing->add_error( 'error_recaptcha', $error );
			}
		}
	}

}
