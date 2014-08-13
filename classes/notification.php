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
	var $n_id = '';

	/**
	 * Get things rolling
	 * 
	 * @since 2.8
	 * @return void
	 */
	function __construct( $n_id ) {
		$this->n_id = $n_id;
	}


}