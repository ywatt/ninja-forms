<?php
/**
 * Timed Submit field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Timed_Submit extends NF_Field_Base {

	/**
	 * @var sidebar
	 * @since 3.0
	 */
	var $sidebar = 'spam';

	/**
	 * Get things started.
	 * Set our nicename.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		$this->nicename = __( 'Timed Submit', 'ninja-forms' );	
	}
	
	/**
	 * Function that renders the textbox itself
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		
	}

	/**
	 * Output our disabled element for the fields list.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		$html ='<input type="submit" class="button-secondary" value="Timed Submit" disabled>';
		echo $html;
	}

}
