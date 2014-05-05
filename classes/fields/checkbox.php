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

	public function render_element() {
		$html = '<input type="hidden" name="' . $this->element_id . '" value="">';
		$html .= '<input type="checkbox" name="' . $this->element_id . '" value="1"' . checked( 1, $this->value, false ) . '>';
		echo $html;
	}
}