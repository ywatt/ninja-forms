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
	var $sidebar = 'general';

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

		unset( $this->settings_sections['restrictions'] );

		unset( $this->registered_settings['display']['default_value'] );
		unset( $this->registered_settings['restrictions']['req'] );
		unset( $this->registered_settings['display']['label_pos'] );

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
