<?php
/**
 * Handles adding and removing forms.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Form
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.9
*/

class NF_Forms {

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 2.9
	 * @return void
	 */
	public function __construct() {
		
	}

	/**
	 * Get all forms
	 * 
	 * @access public
	 * @since 2.9
	 * @return array $forms
	 */
	public function get_all() {
		return nf_get_objects_by_type( 'form' );
	}
}