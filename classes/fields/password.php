<?php
/**
 * Password field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Password extends NF_Field_Base {

	var $label_pos = 'none';
	var $label = 'Password';
	var $re_label = 'Re-enter Password';

	/**
	 * Function that renders the password fields
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = '<label>' . $this->label;
		$html .= '<input type="password" name="' . $this->element_id . '" value="' . $this->value . '" class="' . $this->class . '" placeholder="' . $this->placeholder . '"/>';
		$html .= '</label><br /><label>';
		$html .= $this->re_label;
		$html .= ' <input type="password" name="password_' . $this->field_id . '" value="' . $this->value . '" class="' . $this->class . '" placeholder="' . $this->placeholder . '"/>';
		$html .= '</label>';
		echo $html;
	}

	/**
	 * Custom validation function
	 * 
	 * @access public
	 * @since 3.0
	 * @return bool $return;
	 */
	public function validate() {
		// Check to make sure that the password fields match.
		if ( $this->value != $_POST['password_' . $this->field_id ] )
			return false;
		else
			return true;
	}

}
