<?php if ( ! defined( 'ABSPATH' ) ) exit;

/*
Plugin Name: Ninja Forms
Plugin URI: http://ninjaforms.com/
Description: Ninja Forms is a webform builder with unparalleled ease of use and features.
Version: 2.9.27
Author: The WP Ninjas
Author URI: http://ninjaforms.com
Text Domain: ninja-forms
Domain Path: /lang/
Copyright 2015 WP Ninjas. 
*/

include 'deprecated/ninja-forms.php';

/*
	Deperecated activation function
 */
register_activation_hook( __FILE__, 'ninja_forms_activation' );
