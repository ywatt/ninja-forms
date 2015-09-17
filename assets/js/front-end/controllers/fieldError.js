define(['lib/backbone.radio', 'front-end/models/fieldErrorModel'], function( Radio, fieldErrorModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			Radio.channel( 'fields' ).reply( 'add:error', this.addError );
			Radio.channel( 'fields' ).reply( 'remove:error', this.removeError );
		},

		addError: function( targetID, id, msg ) {
			var model = Radio.channel( 'fields' ).request( 'get:field', targetID );
			var errors = model.get( 'errors' );
			errors.add( { 'id': id, 'msg' : msg } );
			model.set( 'errors', errors );
			model.trigger( 'change:errors', model );
		},

		removeError: function( targetID, id ) {
			var model = Radio.channel( 'fields' ).request( 'get:field', targetID );
			var errors = model.get( 'errors' );
			var targetError = errors.get( id );
			if ( 'undefined' != targetError ) {
				errors.remove( targetError );
				model.set( 'errors', errors );
				model.trigger( 'change:errors', model );
			}
			
		}
	});

	return controller;
} );