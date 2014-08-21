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
	public function edit_screen( $id = '' ) {
		$settings = array(
			'textarea_name' => 'settings[success_message]',
		);
		$loc_opts = apply_filters( 'nf_success_message_locations',
			array(
				array( 'action' => 'ninja_forms_display_before_fields', 'name' => __( 'Before Form', 'ninja-forms' ) ),
				array( 'action' => 'ninja_forms_display_after_fields', 'name' => __( 'After Form', 'ninja-forms' ) ),
			)
		);
		?>
		<tr>
			<th scope="row"><label for="success_message_loc"><?php _e( 'Location', 'ninja-forms' ); ?></label></th>
			<td>
				<select name="settings[success_message_loc]">
					<?php
					foreach ( $loc_opts as $opt ) {
						?>
						<option value="<?php echo $opt['action'];?>" <?php selected( nf_get_object_meta_value( $id, 'success_message_loc' ), $opt['action'] ); ?>><?php echo $opt['name'];?></option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="success_message"><?php _e( 'Message', 'ninja-forms' ); ?></label></th>
			<td>
				<?php wp_editor( nf_get_object_meta_value( $id, 'success_message' ), 'success_message', $settings ); ?>
			</td>
		</tr>

		<?php
	}

}