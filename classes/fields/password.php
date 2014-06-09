<?php
/**
 * Password field class
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Password extends NF_Field_Base {

	var $label_pos = 'none';
	var $label = 'Password';
	var $re_label = 'Re-enter Password';

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
		$this->nicename = __( 'Password', 'ninja-forms' );

		do_action( 'nf_password_construct', $this );
	}

	/**
	 * Function that renders the password fields
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {
		$html = '<label>' . $this->settings['label'];
		$html .= '<input type="password" name="' . $this->element_id . '" value="' . $this->value . '" class="' . $this->settings['class'] . '" placeholder="' . $this->placeholder . '"/>';
		$html .= '</label><br /><label>';
		$html .= $this->re_label;
		$html .= ' <input type="password" name="password_' . $this->field_id . '" value="' . $this->value . '" class="' . $this->settings['class'] . '" placeholder="' . $this->placeholder . '"/>';
		$html .= '</label>';
		echo $html;
	}

	/**
	 * Custom validation function
	 * 
	 * @access public
	 * @since 3.0
	 * @return bool $return;
	 */
	public function validate() {
		// Check to make sure that the password fields match.
		if ( $this->value != $_POST['password_' . $this->field_id ] )
			Ninja_Forms()->field( $this->field_id )->add_error( 'mismatch', __( 'Passwords must match', 'ninja-forms' ) );
	}

	/**
	 * Output our disabled element for the fields list.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function field_list_element() {
		$html ='<input type="password" class="widefat" value="testpassword" disabled>';
		echo $html;
	}

}
