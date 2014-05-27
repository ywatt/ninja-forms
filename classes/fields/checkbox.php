<?php
/**
 * Checkbox field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Checkbox extends NF_Field_Base {

	var $label_pos = 'right';
	
	/**
	 * Get things started.
	 * Set our nicename.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		$this->nicename = __( 'Single Checkbox', 'ninja-forms' );	
	}

	/**
	 * Render our element
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = '<input type="hidden" name="' . $this->element_id . '" value="0">';
		$html .= '<input type="checkbox" name="' . $this->element_id . '" value="1"' . checked( 1, $this->value, false ) . '>';
		echo $html;
	}

	/**
	 * Output our disabled element for the fields list.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		$html ='<input type="checkbox" checked="checked" disabled>';
		echo $html;
	}
}