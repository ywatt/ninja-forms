<?php
/**
 * Text field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Text extends NF_Field_Base {

	/**
	 * Function that renders the textbox itself
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = '<input type="text" name="' . $this->element_id . '" value="' . $this->value . '" class="' . $this->class . '" placeholder="' . $this->placeholder . '"/>';
		echo $html;
	}

}
