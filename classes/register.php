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
	 * @param string $nicename - Display name for section
	 * @since 3.0
	 * @return void
	 */
	public function form_settings_section( $slug, $nicename ) {
		if ( ! empty( $slug ) && ! empty( $nicename ) && ! isset ( Ninja_Forms()->form_settings_sections[ $slug ] ) )
			Ninja_Forms()->form_settings_sections[ $slug ] = $nicename; 
	}

	/**
	 * Function that registers form settings
	 * 
	 * @access public
	 * @param string $section
	 * @param array $settings
	 * @since 3.0
	 * @return void
	 */
	public function form_settings( $section, $settings ) {
		if ( ! empty( $section ) && is_array( $settings ) && ! empty ( $settings ) ) {
			if ( isset ( Ninja_Forms()->registered_form_settings[ $section ] ) ) {
				$new_settings = wp_parse_args( Ninja_Forms()->registered_form_settings[ $section ], $settings );
			} else {
				$new_settings = $settings;
			}
			Ninja_Forms()->registered_form_settings[ $section ] = $new_settings;
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
	public function field_settings_section( $slug, $nicename, $type = 'base' ) {
		if ( ! isset ( Ninja_Forms()->field_types->$type->settings_sections[ $slug ] ) )
			Ninja_Forms()->field_types->$type->settings_sections[ $slug ] = $nicename;			
	}

	/**
	 * Function that registers field settings
	 * 
	 * @access public
	 * @param string $menu
	 * @param array $settings
	 * @since 3.0
	 * @return void
	 */
	public function field_settings( $menu, $settings, $type = 'base' ) {
		if ( ! empty( $menu ) && is_array( $settings ) && ! empty ( $settings ) ) {

			if ( isset ( Ninja_Forms()->field_types->$type->registered_settings[ $menu ] ) ) {
				$new_settings = wp_parse_args( Ninja_Forms()->field_types->$type->registered_settings[ $menu ], $settings );
			} else {
				$new_settings = $settings;
			}

			Ninja_Forms()->field_types->$type->registered_settings[ $menu ] = $new_settings;
		}
	}
}
