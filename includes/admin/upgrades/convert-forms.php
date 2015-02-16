<?php

class NF_Convert_Forms extends NF_Step_Processing {

	function __construct() {
		$this->action = 'convert_forms';

		parent::__construct();
	}

	public function loading() {
		global $wpdb;

		$forms = $wpdb->get_results( 'SELECT id FROM ' . NINJA_FORMS_TABLE_NAME, ARRAY_A );
		$form_count = count( $forms );
		$total_steps = ceil( $form_count / 5 );

		if( empty( $this->total_steps ) || $this->total_steps <= 1 ) {
			$this->total_steps = 1;
		}

		$args = array(
			'total_steps' 	=> $this->total_steps,
			'step' 			=> 1,
		);

		$this->redirect = admin_url( 'admin.php?page=ninja-forms' );

		return $args;
	}

	public function step() {
		global $ninja_forms_fields;

		// 	global $wpdb;
		// // Grab all of our forms.
		// $all_forms = $wpdb->get_results( 'SELECT id FROM ' . NINJA_FORMS_TABLE_NAME, ARRAY_A );

		// foreach ( $all_forms as $form ) {
		// 	nf_29_update_form_settings( $form['id'] );
		// }
		
	}

	public function complete() {
		update_option( 'nf_convert_forms_complete', true );
	}

}