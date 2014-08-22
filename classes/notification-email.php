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
		$form_id = ( '' != $id ) ? Ninja_Forms()->notification( $id )->form_id : '';

		$from_name = nf_get_object_meta_value( $id, 'from_name' );
		$from_address = nf_get_object_meta_value( $id, 'from_address' );
		$reply_to = nf_get_object_meta_value( $id, 'reply_to' );
		$to = nf_get_object_meta_value( $id, 'to' );
		$cc = nf_get_object_meta_value( $id, 'cc' );
		$bcc = nf_get_object_meta_value( $id, 'bcc' );
		$subject = nf_get_object_meta_value( $id, 'subject' );
		
		?>
		<tr>
			<th scope="row"><label for="settings-from_name"><?php _e( 'From Name', 'ninja-forms' ); ?></label></th>
			<td>
				<input name="settings[from_name]" type="text" id="settings-from_name" value="<?php echo $from_name; ?>" class="nf-tokenize" placeholder="Name or fields" data-token-limit="0" data-key="from_name" data-type="name" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="settings-from_address"><?php _e( 'From Address', 'ninja-forms' ); ?></label></th>
			<td>
				<input name="settings[from_address]" type="text" id="settings-from_address" value="<?php echo $from_address; ?>" class="nf-tokenize" placeholder="One email address or field" data-token-limit="1" data-key="from_address" data-type="email" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="settings-reply_to"><?php _e( 'Reply To', 'ninja-forms' ); ?></label></th>
			<td>
				<input name="settings[reply_to]" type="text" id="settings-reply_to" value="<?php echo $reply_to; ?>" class="nf-tokenize" placeholder="One email address or field" data-token-limit="1" data-key="reply_to" data-type="email" />
			</td>
		</tr>			
		<tr>
			<th scope="row"><label for="settings-to"><?php _e( 'To', 'ninja-forms' ); ?></label></th>
			<td>
				<input name="settings[to]" type="text" id="settings-to" value="<?php echo $to; ?>" class="nf-tokenize" placeholder="Email addresses or search for a field" data-token-limit="0" data-key="to" data-type="email" />
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="settings-cc"><?php _e( 'Cc', 'ninja-forms' ); ?></label></th>
			<td>
				<input name="settings[cc]" type="text" id="settings-cc" value="<?php echo $cc; ?>" class="nf-tokenize" placeholder="Email addresses or search for a field" data-token-limit="0" data-key="cc" data-type="email" />
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="settings-bcc"><?php _e( 'Bcc', 'ninja-forms' ); ?></label></th>
			<td>
				<input name="settings[bcc]" type="text" id="settings-bcc" value="<?php echo $bcc; ?>" class="nf-tokenize" placeholder="Email addresses or search for a field" data-token-limit="0" data-key="bcc" data-type="email" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="settings-subject"><?php _e( 'Subject', 'ninja-forms' ); ?></label></th>
			<td>
				<input name="settings[subject]" type="text" id="settings-subject" value="<?php echo $subject; ?>" class="nf-tokenize" placeholder="Subject Text or search for a field" data-token-limit="0" data-key="subject" data-type="all" />
			</td>
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
		if ( '' != $form_id ) {
			$from_name = $this->get_value( $id, 'from_name', $form_id );
			$from_address = $this->get_value( $id, 'from_address', $form_id );
			$reply_to = $this->get_value( $id, 'reply_to', $form_id );
			$to = $this->get_value( $id, 'to', $form_id );
			$cc = $this->get_value( $id, 'cc', $form_id );
			$bcc = $this->get_value( $id, 'bcc', $form_id );			
			$subject = $this->get_value( $id, 'subject', $form_id );			
		} else {
			$from_name = '';
			$from_address = '';
			$reply_to = '';
			$to = '';
			$cc = '';
			$bcc = '';
			$subject = '';
		}

		?>

		<script type="text/javascript">
				nf_notifications.tokens['from_name'] = <?php echo json_encode( $from_name ); ?>;
				nf_notifications.tokens['from_address'] = <?php echo json_encode( $from_address ); ?>;
				nf_notifications.tokens['reply_to'] = <?php echo json_encode( $reply_to ); ?>;
				nf_notifications.tokens['to'] = <?php echo json_encode( $to ); ?>;
				nf_notifications.tokens['cc'] = <?php echo json_encode( $cc ); ?>;
				nf_notifications.tokens['bcc'] = <?php echo json_encode( $bcc ); ?>;
				nf_notifications.tokens['subject'] = <?php echo json_encode( $subject ); ?>;
		</script>

		<?php
	}

	/**
	 * Get our input value labels
	 * 
	 * @access public
	 * @since 2.8
	 * @return string $label
	 */
	public function get_value( $id, $meta_key, $form_id ) {
		$meta_value = nf_get_object_meta_value( $id, $meta_key );
		$meta_value = explode( '|', $meta_value );

		$return = array();
		foreach( $meta_value as $val ) {
			if ( is_numeric( $val ) ) {
				$label = nf_get_field_admin_label( $val, $form_id );
				if ( strlen( $label ) > 30 ) {
					$label = substr( $label, 0, 30 );
				}

				$return[] = array( 'value' => $val, 'label' => $label . ' - ID: ' . $val );
			} else {
				$return[] = array( 'value' => $val, 'label' => $val );
			}
		}

		return $return;
	}

}