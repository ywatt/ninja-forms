<?php
/**
 * Notifications
 * 
 * Adds our notifications to the form edit page.
 * Processes notifications upon form submission.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notifications
{
	/**
	 * Get things rolling
	 * 
	 * @since 2.8
	 */
	function __construct() {
		add_action('admin_init', array( $this, 'register_tab' ) );
	}

	/**
	 * Register our setting tab.
	 * 
	 * @since 2.8
	 * @return void
	 */
	public function register_tab() {
		$form_id = isset ( $_REQUEST['form_id'] ) ? $_REQUEST['form_id'] : '';

		$args = array(
			'name' => __( 'Notifications', 'ninja-forms' ),
			'page' => 'ninja-forms',
			'display_function' => array( $this, 'output_admin' ),
			'save_function' => array( $this, 'save_admin' ),
			'disable_no_form_id' => true,
			'show_save' => true,
			'tab_reload' => false,
		);

		ninja_forms_register_tab( 'notifications', $args );
	}

	/**
	 * Output our notifications admin.
	 * 
	 * @since 2.8
	 * @return void
	 */
	public function output_admin() {
		
	}

	/**
	 * Save our notifications admin.
	 * 
	 * @since 2.8
	 * @return void
	 */
	public function save_admin( $data ) {

	}


}