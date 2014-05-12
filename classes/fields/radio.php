<?php
/**
 * Radio field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Radio extends NF_Field_List {

	/**
	 * Render our element.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = '';
		if ( isset ( $this->items[ $this->field_id ] ) ) {
			foreach ( $this->items[ $this->field_id ] as $item ) {
				$html .=  '<label>' . $item['label'] . '<input type="radio" name="' . $this->element_id .'" value="' . $item['value'] .'" ' . checked( $this->value, $item['value'], false ) . '></label>';
				$html .= '<br>';
			}			
		}

		echo $html;
	}
}
