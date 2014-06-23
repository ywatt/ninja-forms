<?php
/**
 * Date field class
 * Extends the text field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Field_Date extends NF_Field_Text {

	var $sidebar = 'general';

	/**
	 * @var class
	 * @since 3.0
	 */
	var $class = 'date';

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
		$this->nicename = __( 'Date', 'ninja-forms' );

		do_action( 'nf_date_construct', $this );
	}

	public function render_element() {
		if ( $this->settings['datepicker'] == 1 ) {
			$this->settings['class'] = 'datepicker';
		}
		parent::render_element();
	}

	/**
	 * Output our disabled element for the fields list.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		$html ='<input type="text" class="widefat" value="dd/mm/yyyy" disabled>';
		echo $html;
	}
}
