define( ['lib/backbone.radio'], function( Radio ) {
	var fieldsChannel = Radio.channel( 'fields' );

	var fieldController = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( fieldsChannel, 'saveField:saveField', this.saveField );
		},

		saveField: function() {
			
			jQuery( '#nf-main' ).animate( { 'width': '100%' }, 500 );
			jQuery( '#nf-drawer' ).hide( 'slide', { direction: 'right' }, 500 );
		}
	});

	return new fieldController();
} );