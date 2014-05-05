<?php
/**
 * Field Type Class.
 * This class handles organizing, instantiating, and calling functions from the various
 * field type classes.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Field_Types {

	/**
	 * Get things started by looping through our registered field types and instantiating each one.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {

		foreach( Ninja_Forms()->registered_field_types as $slug => $classname ) {
			if ( class_exists( $classname ) )
				$this->$slug = new $classname();
		}
	}
}
