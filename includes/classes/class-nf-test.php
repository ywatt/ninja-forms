<?php
/**
 * Roles and Capabilities
 *
 * @package     EDD
 * @subpackage  Classes/Roles
 * @copyright   Copyright (c) 2012, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.4.4
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Ninja_Forms 
 *
 * This class handles the role creation and assignment of capabilities for those roles.
 *
 * These roles let us have Shop Accountants, Shop Workers, etc, each of whom can do
 * certain things within the EDD store
 *
 * @since 1.4.4
 */
class NF_Test {
	
	private $test_var;

	/**
	 * Get things going
	 *
	 * @access public
	 * @since 1.4.4
	 * @see EDD_Roles::add_roles()
	 * @see EDD_Roles::add_caps()
	 * @return void
	 */

	public function __construct() {
		$this->test_var = 'HELLO WORLD!';
	}

	public function change_var() {
		$this->test_var = 'Goodbye World';
	}

	public function print_var() {
		echo $this->test_var;
	}
}