define(['lib/backbone.radio'], function( Radio ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			Radio.channel( 'nfAdmin' ).reply( 'update:field', this.updateField );
		},

		updateField: function( model, value ) {
			if ( ! model.get( 'isUpdated' ) ) {
				model.set( 'value', value );
				model.set( 'isUpdated', true );
			}
		}
	});

	return controller;
} );