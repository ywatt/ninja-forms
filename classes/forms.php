<?php
/**
 * Handles adding and removing forms.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Form
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.9
*/

class NF_Forms {

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 2.9
	 * @return void
	 */
	public function __construct() {
		
	}

	/**
	 * Get all forms
	 * 
	 * @access public
	 * @since 2.9
	 * @return array $forms
	 */
	public function get_all( $debug = false, $show_new = false ) {
		$forms = nf_get_objects_by_type( 'form' );
		$tmp_array = array();
		foreach ( $forms as $form ) {
			$form_id = $form['id'];

			$status = nf_get_object_meta_value( $form_id, 'status' );
			if ( ( $status == 'new' && $show_new ) || $status != 'new' ) {
				$title = nf_get_object_meta_value( $form_id, 'form_title' );
				if ( strpos( $title, '_' ) === 0 ) {
					if ( $debug )
						$tmp_array[] = $form_id;
				} else {
					$tmp_array[] = $form_id;
				}
			}
		}
		return $tmp_array;
	}
}