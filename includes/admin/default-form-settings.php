<?php

/**
 * Add our default form settings groups and settings.
 * 
 * @since 3.0
 * @return void
 */

function nf_default_form_settings() {
	
	// Register our general settings group
	$args = array(
		'scope' => 'plugin_settings',
		'id' => 'general',
		'label' => 'General Settings',
		'class' => '',
		'priority' => 'core',
		'desc' => __( 'These are settings.', 'ninja-forms' ),
		'display_link' => true,
		'settings' => array(
			'date_format' => array(
				'type' => 'text',
				'desc' => __( 'e.g. m/d/Y, d-m-Y - Tries to follow the <a href="http://www.php.net/manual/en/function.date.php" target="_blank">PHP date() function</a> specifications, but not every format is supported.', 'ninja-forms' ),
				'label' => __( 'Date Format', 'ninja-forms' ),
				'default_value' => 'm/d/Y',
				'class' => 'widefat code',
			),
			'currency_symbol' => array(
				'type' => 'text',
				'label' => __( 'Currency Symbol', 'ninja-forms' ),
				'desc' => __( 'e.g. $, &pound;, &euro;', 'ninja-forms' ),
			),
		),
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );

	$args = array(
		'scope' => 'form',
		'id' => 'display_settings',
		'label' => 'Display',
		'class' => '',
		'priority' => 'core',
		'desc' => __( 'These settings affect how forms are displayed on the front-end.', 'ninja-forms' ),
		'display_link' => true,
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );

	$args = array(
		'scope' => 'form',
		'group' => 'display_settings',
		'settings' => array(
			'name' => array(
				'type' 		=>	'text',
				'desc' 		=> 	__( 'Name your form', 'ninja-forms' ),
				'label' 	=> 	__( 'Name', 'ninja-forms' ),
			),
			'type' => array(
				'type' 		=>	'dropdown',
				'desc' 		=> 	'',
				'label'		=> 	__( 'Select a category', 'ninja-forms' ),
				'options' 	=>	array(
					array( 'name' => '- Select One', 'value' => '' ),
					array( 'name' => 'Contact', 'value' => 'contact' ),
					array( 'name' => 'Support', 'value' => 'support' ),
					array( 'name' => 'Post Creation', 'value' => 'post_creation' ),
				),
			),
			'append_page' => array(
				'type' => 'dropdown',
				'desc' => '',
				'label' => __( 'Add this form to the bottom of this page:', 'ninja-forms' ),
				'options' => array( array( 'name' => 'test', 'value' => 'test'), array( 'name' => 'test2', 'value' => 'test2' ) ),
				'class' => 'widefat code',
			),
			'logged_in' => array(
				'type' => 'checkbox',
				'label' => __( 'Only show this form to logged-in users?', 'ninja-forms' ),
			),
			'ajax' => array(
				'type' => 'checkbox',
				'label' => __( 'Submit the form without reloading the page? (Via Ajax)', 'ninja-forms' ),
			),
			'show_title' => array(
				'type' => 'checkbox',
				'label' => __( 'Output the form title above form?', 'ninja-forms' ),
			),
		),
	);
	Ninja_Forms()->admin_settings->register_settings( $args );	

	$args = array(
		'scope' => 'form',
		'id' => 'wizard',
		'display_link' => false,
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );

	$args = array(
		'scope' => 'form',
		'group' => 'wizard',
		'settings' => array(
			'name' => array(
				'type' 		=>	'text',
				'desc' 		=> 	__( 'Give your form a name. This is how you\'ll identify your form later.', 'ninja-forms' ),
				'label' 	=> 	__( 'Name', 'ninja-forms' ),
			),
			'append_page' => array(
				'type' 		=> 	'dropdown',
				'desc' 		=> 	__( 'The form will appear after the page content', 'ninja-forms' ),
				'label' 	=> 	__( 'Add this form to this page:', 'ninja-forms' ),
				'options' => array(
					array( 'name' => '- Select One', 'value' => '' ),
					array( 'name' => 'test', 'value' => 'test' ), 
					array( 'name' => 'test2', 'value' => 'test2' ),
				),
				'class' => 'widefat code',
			),
		),
	);
	Ninja_Forms()->admin_settings->register_settings( $args );

	$args = array(
		'scope' => 'plugin_settings',
		'id' => 'test',
		'label' => 'TEST',
		'display_link' => true,
		'priority' => 'default',
		'desc' => __( 'This is a test.', 'ninja-forms' ),
		'settings' => array(
			'type' => array(
				'type' => 'dropdown',
				'label' => __( 'Type', 'ninja-forms' ),
				'options' => array(
					array('name' => __( 'Email', 'ninja-forms' ), 'value' => 'email'),
					array('name' => __( 'Success Message', 'ninja-forms' ), 'value' => 'success_message'),
					array('name' => __( 'Pushover', 'ninja-forms' ), 'value' => 'pushover'),
					array('name' => __( 'Text Message', 'ninja-forms' ), 'value' => 'text_message'),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
			),
			'name' => array(
				'type' => 'text',
				'label' => __( 'Name', 'ninja-forms' ),
				'class' => 'widefat',
				'desc' => __( 'How would you like to identify this notification?', 'ninja-forms' ),
			),
			'mailto' => array(
				'type' => 'radio',
				'label' => __( 'Send To', 'ninja-forms' ),
				'options' => array(
					array('name' => __( 'Enter Email', 'ninja-forms' ), 'value' => 'manual_email'),
					array('name' => __( 'Select a Field', 'ninja-forms' ), 'value' => 'field_value'),
					array('name' => __( 'Configure Routing', 'ninja-forms' ), 'value' => 'configure_routing'),
				),
				'class' => '',
				'desc' => __( 'What kind of notification would you like to create?', 'ninja-forms' ),
			),
		),
	);

	Ninja_Forms()->admin_settings->register_settings_group( $args );
}