<?php
/**
 * Submit field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Submit extends NF_Field_Base {

	var $label_pos = 'none';

	public function render_element() {
		$html = '<input type="submit" name="submit" value="' . $this->label . '" />';
		echo $html;
	}
}