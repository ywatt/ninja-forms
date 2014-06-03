<?php
/**
 * HTML field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Html extends NF_Field_Base {

	/**
	 * @var sidebar
	 * @since 3.0
	 */
	var $sidebar = 'layout';

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
		$this->nicename = __( 'HTML', 'ninja-forms' );

		do_action( 'nf_html_construct', $this );
	}
	
	/**
	 * Function that renders the textbox itself
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = $this->value;
		echo $html;
	}

}