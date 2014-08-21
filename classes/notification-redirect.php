<?php
/**
 * Class for our redirect notification type.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notification_Redirect extends NF_Notification_Base_Type
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
			<th scope="row"><label for="settings-redirect_url"><?php _e( 'Url', 'ninja-forms' ); ?></label></th>
			<td><textarea cols="50" name="settings[redirect_url]" id="settings-redirect_url"><?php echo nf_get_object_meta_value( $id, 'redirect_url' ); ?></textarea></td>
		</tr>
		<?php
	}

}