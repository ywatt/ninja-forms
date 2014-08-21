<?php
/**
 * Class for our email notification type.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notification_Email extends NF_Notification_Base_Type
{

	/**
	 * Get things rolling
	 */
	function __construct() {

	}

	/**
	 * Output our edit screen
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function edit_screen( $id = '' ) {
		?>
		<tr>
			<th scope="row"><label for="settings-from"><?php _e( 'From', 'ninja-forms' ); ?></label></th>
			<td><input name="settings[from]" type="text" id="settings-from" value="<?php echo nf_get_object_meta_value( $id, 'from' ); ?>" class="regular-text"></td>
		</tr>			
		<tr>
			<th scope="row"><label for="settings-reply_to"><?php _e( 'Reply To', 'ninja-forms' ); ?></label></th>
			<td><input name="settings[reply_to]" type="text" id="settings-reply_to" value="<?php echo nf_get_object_meta_value( $id, 'reply_to' ); ?>" class="regular-text"></td>
		</tr>			
		<tr>
			<th scope="row"><label for="settings-to"><?php _e( 'To', 'ninja-forms' ); ?></label></th>
			<td><input name="settings[to]" type="text" id="settings-to" value="<?php echo nf_get_object_meta_value( $id, 'to' ); ?>" class="regular-text"></td>
		</tr>		
		<tr>
			<th scope="row"><label for="settings-cc"><?php _e( 'Cc', 'ninja-forms' ); ?></label></th>
			<td><input name="settings[cc]" type="text" id="settings-cc" value="<?php echo nf_get_object_meta_value( $id, 'cc' ); ?>" class="regular-text"></td>
		</tr>		
		<tr>
			<th scope="row"><label for="settings-bcc"><?php _e( 'Bcc', 'ninja-forms' ); ?></label></th>
			<td><input name="settings[bcc]" type="text" id="settings-bcc" value="<?php echo nf_get_object_meta_value( $id, 'bcc' ); ?>" class="regular-text"></td>
		</tr>		
		<tr>
			<th scope="row"><label for="settings-email_message"><?php _e( 'Email Message', 'ninja-forms' ); ?></label></th>
			<td>
				<?php
				$settings = array(
					'textarea_name' => 'settings[email_message]',
				);
				wp_editor( nf_get_object_meta_value( $id, 'email_message' ), 'email_message', $settings ); 
				?>
			</td>
		</tr>
		<?php
	}

}