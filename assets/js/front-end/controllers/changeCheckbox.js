define(['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'checkbox' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'change:field', this.fieldChange );
		},

		fieldChange: function( el, model ) {
			var checked = jQuery( el ).attr( 'checked' );
			if ( checked ) {
				var value = 1;
			} else {
				var value = 0;
			}

			var args = {
				'value' : value,
				'isUpdated' : true
			};
			
			model.set( args );
		}
	});

	return controller;
} );