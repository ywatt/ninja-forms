<?php
/**
 * Register Admin Settings
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Register
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Ninja_Forms 
 *
 * This class handles the registration of admin settings within Ninja Forms.
 *
 * These settings include form, field, notification, and plugin settings.
 *
 * @since 3.0
 */
class NF_Register_Settings {
	
	private $test_var;

	/**
	 * Get things going
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */

	public function __construct() {
		$this->test_var = 'HELLO WORLD!';
	}
}