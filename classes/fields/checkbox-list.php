<?php
/**
 * Checkbox list field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Checkbox_List extends NF_Field_List {

	/**
	 * Get things started.
	 * Set our nicename.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		$this->nicename = __( 'Multi Checkboxes', 'ninja-forms' );	
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

	/* Output our disabled element for the fields list.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		$html ='<span class="disabled">' . __( 'Item 1', 'ninja-forms' ) . ' <input type="checkbox" disabled> ' . __( 'Item 2', 'ninja-forms' ) . ' <input type="checkbox" disabled> ' . __( 'Item 3', 'ninja-forms' ) . ' <input type="checkbox" disabled></span>';
		echo $html;
	}
}
