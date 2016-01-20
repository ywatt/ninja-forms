/**
 * Single item view used for the menu drawer.
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var view = Marionette.CompositeView.extend({
		tagName: 'div',
		template: '#nf-tmpl-menu-drawer'
	});

	return view;
} );