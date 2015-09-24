define(['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'fields' );
	var controller = Marionette.Object.extend( {
		initialize: function( model ) {
			Radio.channel( 'form' ).reply( 'get:errors', this.getFormErrors );
		},

		getFormErrors: function( formID ) {
			var formModel = Radio.channel( 'form' ).request( 'get:form', formID );
			var errors = false;
			if ( formModel ) {
				_.each( formModel.get( 'fields' ).models, function( field ) {
					if ( field.get( 'errors' ).length > 0 ) {
						errors = true;
					}
				} );
			}
			return errors;
		},
	});

	return controller;
} );