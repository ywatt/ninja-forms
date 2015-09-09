define( ['lib/backbone.radio'], function( Radio ) {
	var fieldsChannel = Radio.channel( 'fields' );

	var fieldController = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( fieldsChannel, 'closeAddFields:closeAddFields', this.closeAddFields );
		},

		closeAddFields: function() {
			jQuery( '#nf-main' ).css( 'width', '100%' );
			jQuery( '#nf-drawer' ).hide();
		}
	});

	return new fieldController();
} );