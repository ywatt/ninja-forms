<?php
/**
 * Registration class. Responsible for handling registration of fields and sidebars
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Register
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Register {

	/**
	 * Function that registers a field type
	 * 
	 * @access public
	 * @param string $slug - Field type slug. Must be unique.
	 * @param string $classname - Name of the class that should be used for the field type.
	 * @since 3.0
	 * @return void
	 */
	public function field( $slug, $classname ) {
		if ( ! empty( $slug ) && ! empty( $classname ) && ! isset ( Ninja_Forms()->registered_field_types[ $slug ] ) )
			Ninja_Forms()->registered_field_types[ $slug ] = $classname;
	}
	
}
