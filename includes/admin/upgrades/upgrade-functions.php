<?php
/**
 * Upgrade Functions
 *
 * @package     Ninja Forms
 * @subpackage  Admin/Upgrades
 * @copyright   Copyright (c) 2014, WP Ninjas
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.7
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display Upgrade Notices
 *
 * @since 2.7
 * @return void
*/
function nf_show_upgrade_notices() {

	// Convert notifications
	if ( isset ( $_GET['page'] ) && $_GET['page'] == 'nf-processing' )
		return; // Don't show notices on the processing page.

	$n_conversion_complete = get_option( 'nf_convert_notifications_complete', false );

	if ( ! $n_conversion_complete ) {
		printf(
			'<div class="update-nag"><p>' . __( 'Ninja Forms needs to upgrade your form notifications, click <a href="%s">here</a> to start the upgrade.', 'ninja-forms' ) . '</p></div>',
			admin_url( 'index.php?page=nf-processing&action=convert_notifications' )
		);
	}

	$update_email_settings_complete = get_option( 'nf_update_email_settings_complete', false );

	if ( $n_conversion_complete && ! $update_email_settings_complete ) {
		printf(
			'<div class="update-nag"><p>' . __( 'Ninja Forms needs to update your email settings, click <a href="%s">here</a> to start the upgrade.', 'ninja-forms' ) . '</p></div>',
			admin_url( 'index.php?page=nf-processing&action=update_email_settings' )
		);
	}

	if ( isset( $_GET['page'] ) && $_GET['page'] == 'nf-upgrades' )
		return; // Don't show notices on the upgrades page

	$step = get_option( 'nf_convert_subs_step' );

	if ( $step != 'complete' ) {
		if ( empty( $step ) ) {
			$step = 1;
		}
		printf(
			'<div class="update-nag"><p>' . __( 'Ninja Forms needs to upgrade the submissions table, click <a href="%s">here</a> to start the upgrade.', 'ninja-forms' ) . '</p></div>',
			admin_url( 'index.php?page=nf-upgrades&nf-upgrade=upgrade_subs_to_cpt&step=' . $step )
		);
	}

	$upgrade_notice = get_option( 'nf_upgrade_notice' );

	if ( $upgrade_notice != 'closed' ) {
		printf(
			'<div class="update-nag"><p>' . __( 'Thank you for updating to version 2.7 of Ninja Forms. Please update any Ninja Forms extensions from ', 'ninja-forms' ) . '<a href="http://ninjaforms.com/your-account/purchases/"</a>ninjaforms.com</a>. <a href="%s">Dismiss this notice</a></p></div>',
			add_query_arg( array( 'nf_action' => 'dismiss_upgrade_notice' ) )
		);
	}

	if ( defined( 'NINJA_FORMS_UPLOADS_VERSION' ) && version_compare( NINJA_FORMS_UPLOADS_VERSION, '1.3.5' ) == -1 ) {
		echo '<div class="error"><p>' . __( 'Your version of the Ninja Forms File Upload extension isn\'t compatible with version 2.7 of Ninja Forms. It needs to be at least version 1.3.5. Please update this extension at ', 'ninja-forms' ) . '<a href="http://ninjaforms.com/your-account/purchases/"</a>ninjaforms.com</a></p></div>';
	}

	if ( defined( 'NINJA_FORMS_SAVE_PROGRESS_VERSION' ) && version_compare( NINJA_FORMS_SAVE_PROGRESS_VERSION, '1.1.3' ) == -1 ) {
		echo '<div class="error"><p>' . __( 'Your version of the Ninja Forms Save Progress extension isn\'t compatible with version 2.7 of Ninja Forms. It needs to be at least version 1.1.3. Please update this extension at ', 'ninja-forms' ) . '<a href="http://ninjaforms.com/your-account/purchases/"</a>ninjaforms.com</a></p></div>';
	}
}
add_action( 'admin_notices', 'nf_show_upgrade_notices' );

/**
 * Triggers all upgrade functions
 *
 * This function is usually triggered via AJAX
 *
 * @since 2.7
 * @return void
*/
function nf_trigger_upgrades() {
	if ( DOING_AJAX )
		die( 'complete' ); // Let AJAX know that the upgrade is complete
}
add_action( 'wp_ajax_edd_trigger_upgrades', 'nf_trigger_upgrades' );

/**
 * Upgrades for Ninja Forms v2.7 and Submission Custom Post Type.
 *
 * @since 2.7
 * @return void
 */
function nf_v27_upgrade_subs_to_cpt() {
	//Bail if we aren't in the admin.
	if ( ! is_admin() )
		return false;

	// Bail if we don't have the appropriate permissions.
	if ( is_multisite() ) {
		if ( ! is_super_admin() )
			return false;
	} else {
		if ( ! current_user_can( 'install_plugins' ) )
			return false;
	}

	ignore_user_abort( true );

	if ( ! nf_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
		//set_time_limit( 0 );
	}

	$step   = isset( $_GET['step'] )  ? absint( $_GET['step'] )  : 1;
	$total  = isset( $_GET['total'] ) ? absint( $_GET['total'] ) : false;
	$number  = isset( $_GET['custom'] ) ? absint( $_GET['custom'] ) : 1;

	if ( get_option( 'nf_convert_subs_num' ) ) {
		$number = get_option( 'nf_convert_subs_num' );
	}

	$form_id  = isset( $_GET['form_id'] ) ? absint( $_GET['form_id'] ) : 0;

	update_option( 'nf_convert_subs_step', $step );

	$convert_subs = new NF_Convert_Subs();
	$old_sub_count = $convert_subs->count_old_subs();

	if( empty( $total ) || $total <= 1 ) {
		$total = round( ( $old_sub_count / 100 ), 0 ) + 2;
	}

	if ( $step <= $total ) {
		if ( $step == 1 ) {
			$begin = 0;
		} else {
			$begin = ( $step - 1 ) * 100;
		}

		$subs_results = $convert_subs->get_old_subs( $begin, 100 );

		if ( is_array( $subs_results ) && ! empty( $subs_results ) ) {

			foreach ( $subs_results as $sub ) {
				if ( $form_id != $sub['form_id'] ) {
					$form_id = $sub['form_id'];
					$number = 1;
				}
				$converted = get_option( 'nf_converted_subs' );
				if ( empty( $converted ) )
					$converted = array();

				if ( ! in_array( $sub['id'], $converted ) ) {
					$convert_subs->convert( $sub, $number );

					$converted[] = $sub['id'];
					update_option( 'nf_converted_subs', $converted );
					$number++;
					update_option( 'nf_convert_subs_num', $number );
				}
			}
		}

		$step++;

		$redirect = add_query_arg( array(
			'page'        	=> 'nf-upgrades',
			'nf-upgrade' 	=> 'upgrade_subs_to_cpt',
			'step'        	=> $step,
			'custom'      	=> $number,
			'total'       	=> $total,
			'form_id'		=> $form_id
		), admin_url( 'index.php' ) );
		wp_redirect( $redirect ); exit;

	} else {
		update_option( 'nf_convert_subs_step', 'complete' );
		delete_option( 'nf_convert_subs_num' );
		wp_redirect( admin_url( 'index.php?page=nf-about' ) ); exit;
	}
}
add_action( 'nf_upgrade_subs_to_cpt', 'nf_v27_upgrade_subs_to_cpt' );

/**
 * Keep our upgrade notice closed.
 *
 * @since 2.7
 * @return void
 */
function nf_dismiss_upgrade_notice() {
	update_option( 'nf_upgrade_notice', 'closed' );
	wp_redirect( remove_query_arg( 'nf_action' ) );
	exit;
}

add_action( 'nf_dismiss_upgrade_notice', 'nf_dismiss_upgrade_notice' );


/**
 * Clearing out the old email favourite field and replacing it with the new version.
 * 
 * @since 2.8.4
 * @return void
 */
function nf_clear_old_email_fav() {
	global $wpdb;

	$email_fav_updated = get_option( 'nf_email_fav_updated', false );

	if ( $email_fav_updated )
		return false;

	nf_change_email_fav();
	nf_remove_old_email_settings();

	update_option( 'nf_email_fav_updated', true );
}

add_action( 'admin_init', 'nf_clear_old_email_fav' );

/**
 * Remove old email "send to" settings from form fiels.
 * 
 * @since 2.8.4
 * @return void
 */
function nf_remove_old_email_settings( $form_id = '' ) {

	if ( '' == $form_id ) {
		$forms = ninja_forms_get_all_forms( true );

		if ( is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				nf_remove_old_email_send_to( $form['id'] );
			}
		}
	} else {
		nf_remove_old_email_send_to( $form_id );
	}
}

/**
 * Removes old email settings form a single form.
 * 
 * @since 2.8.4
 * @return void
 */
function nf_remove_old_email_send_to( $form_id ) {
	if ( empty ( $form_id ) )
		return false;

	// Update any old email settings we have.
	$fields = Ninja_Forms()->form( $form_id )->fields;

	// Create a notification for our user email
	if ( ! empty ( $fields ) ) {
		foreach ( $fields as $field_id => $field ) {
			if ( isset ( $field['data']['send_email'] ) && $field['data']['send_email'] == 1 ) {
				// Add this field to our $addresses variable.
				unset( $field['data']['send_email'] );
				unset( $field['data']['replyto_email'] );
				unset( $field['data']['from_name'] );

				$args = array(
					'update_array'	=> array(
						'data'		=> serialize( $field['data'] ),
					),
					'where'			=> array(
						'id' 		=> $field_id,
					),
				);

				ninja_forms_update_field( $args );
			}
		}
	}
}

/**
 * Remove the old copy of our email defined field and replace it.
 * 
 * @since 2.8.4
 * @return void
 */
function nf_change_email_fav() {
	global $wpdb;

	$email_address = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".NINJA_FORMS_FAV_FIELDS_TABLE_NAME." WHERE name = %s AND row_type = 0", 'Email' ), ARRAY_A );

	if( isset($email_address['id']) ){
		$sql = 'DELETE FROM `' . NINJA_FORMS_FAV_FIELDS_TABLE_NAME . '` WHERE id = ' . $email_address['id'];
		$wpdb->query( $sql );
	}

	$sql = 'INSERT INTO `'.NINJA_FORMS_FAV_FIELDS_TABLE_NAME.'` (`id`, `row_type`, `type`, `order`, `data`, `name`) VALUES
	(1, 0, \'_text\', 0, \'a:25:{s:5:"label";s:5:"Email";s:9:"label_pos";s:5:"above";s:13:"default_value";s:0:"";s:4:"mask";s:0:"";s:10:"datepicker";s:1:"0";s:5:"email";s:1:"1";s:10:"send_email";s:1:"0";s:10:"from_email";s:1:"0";s:10:"first_name";s:1:"0";s:9:"last_name";s:1:"0";s:9:"from_name";s:1:"0";s:14:"user_address_1";s:1:"0";s:14:"user_address_2";s:1:"0";s:9:"user_city";s:1:"0";s:8:"user_zip";s:1:"0";s:10:"user_phone";s:1:"0";s:10:"user_email";s:1:"1";s:21:"user_info_field_group";s:1:"1";s:3:"req";s:1:"0";s:5:"class";s:0:"";s:9:"show_help";s:1:"0";s:9:"help_text";s:0:"";s:17:"calc_auto_include";s:1:"0";s:11:"calc_option";s:1:"0";s:11:"conditional";s:0:"";}\', \'Email Address\')';
	$wpdb->query($sql);
}

