<?php
/*
 * Function to register a new field for user's country
 *
 * @since 2.2.37
 * @returns void
 */

function ninja_forms_register_field_credit_card(){

	$reg_field = apply_filters( 'ninja_forms_enable_credit_card_field', false );

	$args = array(
		'name' => __( 'Credit Card', 'ninja-forms' ),
		'sidebar' => '',
		'display_function' => 'ninja_forms_field_credit_card_display',
		'group' => 'standard_fields',
		'edit_conditional' => true,
		'edit_custom_class' => false,
		'edit_options' => array(),
		//'post_process' => 'ninja_forms_field_credit_card_test',
		'save_sub' => false,
		'process_field' => false,
		'edit_label_pos' => false,
		'edit_options' => array(
			array(
				'type' => 'hidden',
				'name' => 'payment_field_group',
				'default' => 1,
			),
		),
	);

	if ( $reg_field ) {
		ninja_forms_register_field( '_credit_card', $args );
	}
}

add_action( 'init', 'ninja_forms_register_field_credit_card' );

/*
 * Function to display our credit_card field on the front-end.
 *
 * @since 2.2.37
 * @returns void
 */

function ninja_forms_field_credit_card_display( $field_id, $data ) {
	global $ninja_forms_processing;

	if( isset( $data['default_value'] ) ) {
		$default_value = $data['default_value'];
	}else{
		$default_value = '';
	}

	if ( isset ( $ninja_forms_processing ) ){
		$name = $ninja_forms_processing->get_extra_value( '_credit_card_name' );
		$expiry_month = $ninja_forms_processing->get_extra_value( '_credit_card_expiry_month' );
		$expiry_year = $ninja_forms_processing->get_extra_value( '_credit_card_expiry_year' );
		$card_number_errors = $ninja_forms_processing->get_errors_by_location( 'credit_card_number' );
		$card_cvc_errors = $ninja_forms_processing->get_errors_by_location( 'credit_card_cvc' );
		$card_name_errors = $ninja_forms_processing->get_errors_by_location( 'credit_card_name' );
		$card_month_errors = $ninja_forms_processing->get_errors_by_location( 'credit_card_month' );
		$card_year_errors = $ninja_forms_processing->get_errors_by_location( 'credit_card_year' );
	} else {
		$name = '';
		$expiry_month = '';
		$expiry_year = '';
		$card_number_errors = '';
		$card_cvc_errors = '';
		$card_name_errors = '';
		$card_month_errors = '';
		$card_year_errors = '';
	}

	$field_class = ninja_forms_get_field_class( $field_id );
	$post_field = apply_filters( 'ninja_forms_post_credit_card_field', false );
	?>
		<div class="ninja-forms-credit-card-number"> <!-- Open Credit Card Wrap -->
			<label><?php _e( 'Card Number', 'ninja-forms' ); ?></label>
			<span><?php _e( 'The (typically) 16 digits on the front of your credit card.', 'ninja-forms' ); ?></span>
			<input type="text" <?php if ( $post_field ){ echo 'name="_credit_card_number"'; } ?> class="ninja-forms-field card-number">
		</div>
		<div class="ninja-forms-credit-card-number-error ninja-forms-field-error">
			<?php
			if ( $card_number_errors ) {
				if( is_array( $card_number_errors ) ) {
					foreach ( $card_number_errors as $error ) {
						echo '<p>'.$error['msg'].'</p>';
					}
				}
			}
			?>
		</div>
		<div class="ninja-forms-credit-card-cvc"> <!-- [open_cvc_wrap] -->
			<label><?php _e( 'CVC', 'ninja-forms' ); ?></label>
			<span><?php _e( 'The 3 digit (back) or 4 digit (front) value on your card.', 'ninja-forms' ); ?></span>
			<input type="text" <?php if ( $post_field ){ echo 'name="_credit_card_cvc"'; } ?> class="ninja-forms-field card-cvc">
		</div>
		<div class="ninja-forms-credit-card-cvc-error ninja-forms-field-error">
			<?php
			if ( $card_cvc_errors ) {
				if( is_array( $card_cvc_errors ) ) {
					foreach ( $card_cvc_errors as $error ) {
						echo '<p>'.$error['msg'].'</p>';
					}
				}
			}
			?>
		</div>
		<div class="ninja-forms-credit-card-name"> <!-- [open_nameoncard_wrap] -->
			<label><?php _e( 'Name on the Card', 'ninja-forms' ); ?></label>
			<span><?php _e( 'The name printed on the front of your credit card.', 'ninja-forms' ); ?></span>
			<input type="text" <?php if ( $post_field ){ echo 'name="_credit_card_name"'; } ?> class="ninja-forms-field card-name" value="<?php echo $name;?>">
		</div>
		<div class="ninja-forms-credit-card-name-error ninja-forms-field-error">
			<?php
			if ( $card_name_errors ) {
				if( is_array( $card_name_errors ) ) {
					foreach ( $card_name_errors as $error ) {
						echo '<p>'.$error['msg'].'</p>';
					}
				}
			}
			?>
		</div>
		<div class="ninja-forms-credit-card-exp-month"> <!-- [open_expires_wrap] -->
			<label><?php _e( 'Expiration Month (MM)', 'ninja-forms' ); ?></label>
			<span><?php _e( 'The month your credit card expires, typically on the front of the card.', 'ninja-forms' ); ?></span>
			<input type="text" <?php if ( $post_field ){ echo 'name="_credit_card_expires_month"'; } ?> class="ninja-forms-field ninja-forms-mask card-expiry-month" data-mask="99" value="<?php echo $expiry_month;?>">
		</div>
		<div class="ninja-forms-credit-card-exp-month-error ninja-forms-field-error">
			<?php
			if ( $card_month_errors ) {
				if( is_array( $card_month_errors ) ) {
					foreach ( $card_month_errors as $error ) {
						echo '<p>'.$error['msg'].'</p>';
					}
				}
			}
			?>
		</div> <!-- [close_exp_year_wrap] -->
		<div class="ninja-forms-credit-card-exp-year"> <!-- [open_expires_wrap] -->
			<label><?php _e( 'Expiration Year (YYYY)', 'ninja-forms' ); ?></label>
			<span><?php _e( 'The year your credit card expires, typically on the front of the card.', 'ninja-forms' ); ?></span>
			<input type="text" <?php if ( $post_field ){ echo 'name="_credit_card_expires_year"'; } ?> class="ninja-forms-field ninja-forms-mask card-expiry-year" data-mask="9999" value="<?php echo $expiry_year;?>">
		</div>
		<div class="ninja-forms-credit-card-exp-year-error ninja-forms-field-error">
			<?php
			if ( $card_year_errors ) {
				if( is_array( $card_year_errors ) ) {
					foreach ( $card_year_errors as $error ) {
						echo '<p>'.$error['msg'].'</p>';
					}
				}
			}
			?>
		</div> <!-- [close_exp_month_wrap] -->
	<?php
}

/*
 *
 * Function that filters the display script field data so that the mask is included for the expires field.
 *
 * @since 2.2.37
 * @returns array $data
 */

function ninja_forms_field_credit_card_expire_filter( $data, $field_id ){
	$field = ninja_forms_get_field_by_id( $field_id );
	if ( $field['type'] == '_credit_card' ) {
		$data['mask'] = '99/9999';
	}
	return $data;
}

add_action( 'ninja_forms_display_script_field_data', 'ninja_forms_field_credit_card_expire_filter', 10, 2 );