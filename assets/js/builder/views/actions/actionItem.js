/**
 * Single action table row
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
		tagName: 'tr',
		template: '#nf-tmpl-action-item',

		templateHelpers: function() {
			return {

				renderToggle: function() {
					this.label = '';
					this.value = this.active;
					this.name = this.id + '-active';
					return _.template( jQuery( '#nf-tmpl-edit-field-setting-toggle' ).html(), this );
				}
			}
		}
	});

	return view;
} );