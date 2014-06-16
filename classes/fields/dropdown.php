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
	 * Get things started.
	 * Set our nicename.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->nicename = __( 'Dropdown', 'ninja-forms' );

		$this->registered_settings['display']['label_pos']['options'] = array(
			array( 'name' => __( 'None', 'ninja-forms' ), 'value' => 'none' ),
			array( 'name' => __( 'Above Element', 'ninja-forms' ), 'value' => 'above' ),
			array( 'name' => __( 'Left of Element', 'ninja-forms' ), 'value' => 'left' ),
			array( 'name' => __( 'Right of Element', 'ninja-forms' ), 'value' => 'right' ),
			array( 'name' => __( 'Below Element', 'ninja-forms' ), 'value' => 'below' ),
		);

		do_action( 'nf_dropdown_construct', $this );
	}

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
			foreach ( $this->items[ $this->field_id ] as $item_id => $item ) {
				$html .= '<option value="' . $item['value'] .'" ' . selected( $this->value, $item_id, false ) . '>' . $item['label'] . '</option>';
			}			
		}

		$html .= '</select>';
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
		$html ='<select disabled><option>' . __( 'Option', 'ninja-forms' ) . '</option></select>';
		echo $html;
	}
}
