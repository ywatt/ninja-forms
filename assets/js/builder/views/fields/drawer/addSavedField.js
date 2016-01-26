define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-add-saved-field',

		events: {
			'click .nf-button': 'clickAddSavedField'
		},

		clickAddSavedField: function( e ) {
			nfRadio.channel( 'drawer' ).trigger( 'click:addSavedField', e, this.model );
		}
	});

	return view;
} );
