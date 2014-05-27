<?php
/**
 * Multi Select list field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Multi_Select extends NF_Field_List {

	/**
	 * Get things started.
	 * Set our nicename.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		$this->nicename = __( 'Multi Select', 'ninja-forms' );	
	}

	/**
	 * Render our element.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {

	}
}
