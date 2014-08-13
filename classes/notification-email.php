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
	public function edit_screen( $id ) {
		?>
		<tr>
			<th scope="row"><label for="to"><?php _e( 'To', 'ninja-forms' ); ?></label></th>
			<td><input name="to" type="text" id="to" value="<?php echo nf_get_object_meta_value( $id, 'to' ); ?>" class="regular-text"></td>
		</tr>		
		<tr>
			<th scope="row"><label for="cc"><?php _e( 'Cc', 'ninja-forms' ); ?></label></th>
			<td><input name="cc" type="text" id="cc" value="<?php echo nf_get_object_meta_value( $id, 'cc' ); ?>" class="regular-text"></td>
		</tr>		
		<tr>
			<th scope="row"><label for="bcc"><?php _e( 'Bcc', 'ninja-forms' ); ?></label></th>
			<td><input name="bcc" type="text" id="bcc" value="<?php echo nf_get_object_meta_value( $id, 'bcc' ); ?>" class="regular-text"></td>
		</tr>
		<?php
	}

}