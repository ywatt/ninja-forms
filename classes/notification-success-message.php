<?php
/**
 * Class for our success message notification type.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notification_Success_Message extends NF_Notification_Base_Type
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
			<th scope="row"><label for="message"><?php _e( 'Message', 'ninja-forms' ); ?></label></th>
			<td>
				<?php wp_editor( nf_get_object_meta_value( $id, 'message' ), 'message' ); ?>
			</td>
		</tr>

		<?php
	}

}