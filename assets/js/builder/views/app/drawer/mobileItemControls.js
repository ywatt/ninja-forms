/**
 * Shows delete/duplicate item controls in the bottom of the drawer.
 *
 * CSS hides this if the user isn't on mobile.
 * 
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-footer-edit-settings'
	});

	return view;
} );