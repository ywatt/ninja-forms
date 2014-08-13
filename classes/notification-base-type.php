<?php
/**
 * Class for notification types. 
 * This is the parent class. it should be extended by specific notification types
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notification_Base_Type
{
	/**
	 * Get things rolling
	 *
	 * @since 2.8
	 */
	function __construct() {

	}

	/**
	 * Processing function
	 * 
	 * @access public
	 * @since 2.8
	 * @return false
	 */
	public function processing() {
		// This space left intentionally blank
	}

	/**
	 * Display function
	 * 
	 * @access public
	 * @since 2.8
	 * @return false
	 */
	public function edit_screen( $id ) {
		// This space left intentionally blank
	}
	
}