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

	/**
	 * Function that registers form settings sidebars
	 * 
	 * @access public
	 * @param string $slug - Sidebar slug. Must be unique.
	 * @param string $nicename - Display name for sidebar
	 * @since 3.0
	 * @return void
	 */
	public function form_settings_sidebar( $slug, $nicename ) {
		if ( ! empty( $slug ) && ! empty( $nicename ) && ! isset ( Ninja_Forms()->registered_form_settings_menu[ $slug ] ) )
			Ninja_Forms()->registered_form_settings_menu[ $slug ] = $nicename; 
	}

	/**
	 * Function that registers form settings
	 * 
	 * @access public
	 * @param string $sidebar
	 * @param array $settings
	 * @since 3.0
	 * @return void
	 */
	public function form_settings( $sidebar, $settings ) {
		if ( ! empty( $sidebar ) && is_array( $settings ) && ! empty ( $settings ) ) {
			if ( isset ( Ninja_Forms()->registered_form_settings[ $sidebar ] ) ) {
				$new_settings = wp_parse_args( Ninja_Forms()->registered_form_settings[ $sidebar ], $settings );
			} else {
				$new_settings = $settings;
			}
			Ninja_Forms()->registered_form_settings[ $sidebar ] = $new_settings;
		}
	}	

	/**
	 * Function that registers field settings sidebars
	 * 
	 * @access public
	 * @param string $slug - Sidebar slug. Must be unique.
	 * @param string $nicename - Display name for sidebar
	 * @since 3.0
	 * @return void
	 */
	public function field_settings_sidebar( $slug, $nicename ) {
		if ( ! empty( $slug ) && ! empty( $nicename ) && ! isset ( Ninja_Forms()->registered_field_settings_menu[ $slug ] ) )
			Ninja_Forms()->registered_field_settings_menu[ $slug ] = $nicename; 
	}

	/**
	 * Function that registers field settings
	 * 
	 * @access public
	 * @param string $sidebar
	 * @param array $settings
	 * @since 3.0
	 * @return void
	 */
	public function field_settings( $sidebar, $settings ) {
		if ( ! empty( $sidebar ) && is_array( $settings ) && ! empty ( $settings ) ) {
			if ( isset ( Ninja_Forms()->registered_field_settings[ $sidebar ] ) ) {
				$new_settings = wp_parse_args( Ninja_Forms()->registered_field_settings[ $sidebar ], $settings );
			} else {
				$new_settings = $settings;
			}
			Ninja_Forms()->registered_field_settings[ $sidebar ] = $new_settings;
		}
	}
	
}
