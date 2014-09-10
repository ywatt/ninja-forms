<?php
/**
 * Class for notification types. 
 * This is the parent class. it should be extended by specific notification types
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notification_Base_Type
{

	/**
	 * Get things rolling
	 *
	 * @since 2.8
	 */
	function __construct() {

	}

	/**
	 * Processing function
	 * 
	 * @access public
	 * @since 2.8
	 * @return false
	 */
	public function process( $id ) {
		// This space left intentionally blank
	}

	/**
	 * Output admin edit screen
	 * 
	 * @access public
	 * @since 2.8
	 * @return false
	 */
	public function edit_screen( $id = '' ) {
		// This space left intentionally blank
	}

	/**
	 * Save admin edit screen
	 * 
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function save_admin( $id = '', $data ) {
		// This space left intentionally blank
		return $data;
	}

	/**
	 * Remove fields from the generated table if their value is bool(false)
	 * 
	 * @access public
	 * @since 2.8
	 * @return string $table
	 */
	public function remove_empty_fields_from_table( $table = '' ) {
		global $ninja_forms_processing;

		if ( empty ( $table ) )
			return $table;

		$doc = new DOMDocument();
		$doc->loadHTML( $table );

		foreach ( $ninja_forms_processing->get_all_fields() as $field_id => $user_value ) {
			if ( ! $user_value ) {
				$element = $doc->getElementById( 'ninja_forms_field_' . $field_id );
				if ( is_object( $element ) )
					$element->parentNode->removeChild( $element );
			}
		}

		$table = $doc->saveHTML();

		return $table;
	}
	
}