<?php
/**
 * Notification
 * 
 * Single notification object.
 * This object lets us call it like: Ninja_Forms()->notification( 33 )->methods()
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notification
{

	/**
	 * @var notification id
	 */
	var $id = '';

	/**
	 * @var type
	 */
	var $type = '';

	/**
	 * Get things rolling
	 * 
	 * @since 2.8
	 * @return void
	 */
	function __construct( $id ) {
		$this->id = $id;
		$this->type = nf_get_object_meta_value( $id, 'type' );
	}

	/**
	 * Ouptut our admin screen
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function edit_screen() {
		// Call our type edit screen.
		Ninja_Forms()->notification_email->edit_screen( $this->id );
	}


}