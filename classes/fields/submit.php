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
	var $add_to_sub = false;

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
		$this->nicename = __( 'Submit Button', 'ninja-forms' );

		$this->registered_settings['general']['default_value']['type'] = 'custom';
		$this->registered_settings['general']['req']['type'] = 'custom';
		$this->registered_settings['display']['label_pos']['type'] = 'custom';

		do_action( 'nf_submit_construct', $this );
	}

	/**
	 * Render our display element
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = '<input type="submit" name="submit" value="' . $this->settings['label'] . '" />';
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
		$html ='<input type="submit" class="button-secondary" value="' . __( 'Submit', 'ninja-forms' ) . '" disabled>';
		echo $html;
	}
}
