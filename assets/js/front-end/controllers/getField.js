define(['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'fields' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			Radio.channel( 'fields' ).reply( 'get:field', this.getField );
		},

		getField: function( id ) {
			var model = false;
			
			return model;
		}
	});

	return controller;
} );