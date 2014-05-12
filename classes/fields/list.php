<?php
/**
 * List field class
 * This class should be extended, and isn't registered itself.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_List extends NF_Field_Base {

	/**
	 * @var items
	 * @since 3.0
	 */
	var $items = array();

	/**
	 * Custom setup function. We need to 
	 * get our list of items for this list field.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function setup() {
		if ( ! isset ( $this->items[ $this->field_id ] ) ) {
			$this->items[ $this->field_id ] = nf_get_object_children( $this->field_id, 'list_item' );
		}
	}
}
