define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-add-saved-field',

		initialize: function() {
			this.model.on( 'change:addSavedLoading', this.render, this );
		},

		onBeforeDestroy: function() {
			this.model.off( 'change:addSavedLoading', this.render );
		},

		events: {
			'click .nf-button': 'clickAddSavedField'
		},

		clickAddSavedField: function( e ) {
			nfRadio.channel( 'drawer' ).trigger( 'click:addSavedField', e, this.model );
		},

		templateHelpers: function() {
			return {
				renderAddButton: function() {
					if ( this.addSavedLoading ) {
						return _.template( jQuery( '#nf-tmpl-add-saved-field-loading' ).html(), this );
					} else {
						return _.template( jQuery( '#nf-tmpl-add-saved-field-button' ).html(), this );
					}
					
				}
			};
		}
	});

	return view;
} );
