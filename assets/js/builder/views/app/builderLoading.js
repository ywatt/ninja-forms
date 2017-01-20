/**
 * Builder loading view.
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2017 WP Ninjas
 * @since 3.0.25
 */
define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#tmpl-nf-builder-loading',
		el: '#nf-builder',

		initialize: function() {
			this.render();
		}
	});

	return view;
} );