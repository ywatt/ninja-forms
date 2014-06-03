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
	 * Get things started.
	 * Set our nicename.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->nicename = __( 'Radio Buttons', 'ninja-forms' );

		do_action( 'nf_radio_construct', $this );
	}

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

	/**
	 * Output our disabled element for the fields list.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		$html ='<span class="disabled">' . __( 'Item 1', 'ninja-forms' ) . ' <input type="radio" disabled> ' . __( 'Item 2', 'ninja-forms' ) . ' <input type="radio" disabled> ' . __( 'Item 3', 'ninja-forms' ) . ' <input type="radio" disabled></span>';
		echo $html;
	}
}
