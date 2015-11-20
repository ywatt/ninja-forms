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

		events: {
			'click .nf-edit-settings': 'clickEdit',
			'click .nf-delete': 'clickDelete',
			'click .nf-duplicate': 'clickDuplicate'
		},

		clickEdit: function( e ) {
			nfRadio.channel( 'actions' ).trigger( 'click:edit', e, this.model );
		},

		clickDelete: function( e ) {
			nfRadio.channel( 'actions' ).trigger( 'click:delete', e, this.model );
		},

		clickDuplicate: function( e ) {
			nfRadio.channel( 'actions' ).trigger( 'click:duplicate', e, this.model );
		},

		templateHelpers: function() {
			return {

				renderToggle: function() {
					this.label = '';
					this.value = this.active;
					this.name = this.id + '-active';
					return _.template( jQuery( '#nf-tmpl-edit-setting-toggle' ).html(), this );
				}
			}
		}
	});

	return view;
} );