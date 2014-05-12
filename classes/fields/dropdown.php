<?php
/**
 * Dropdown field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Dropdown extends NF_Field_List {

	/**
	 * Render our element.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = '<select>';
		if ( isset ( $this->items[ $this->field_id ] ) ) {
			foreach ( $this->items[ $this->field_id ] as $item ) {
				$html .= '<option value="' . $item['value'] .'" ' . selected( $this->value, $item['value'], false ) . '>' . $item['label'] . '</option>';
			}			
		}

		$html .= '</select>';
		echo $html;
	}
}
