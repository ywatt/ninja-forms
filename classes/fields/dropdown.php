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
			foreach ( $this->items[ $this->field_id ] as $item ) {
				$html .= '<option value="' . $item['value'] .'" ' . selected( $this->value, $item['value'], false ) . '>' . $item['label'] . '</option>';
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
