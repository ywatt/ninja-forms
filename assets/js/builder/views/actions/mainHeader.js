/**
 * Add main header.
 *
 * TODO: make dynamic
 * 
 * @package Ninja Forms builder
 * @subpackage Actions
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main-header-actions'
	});

	return view;
} );