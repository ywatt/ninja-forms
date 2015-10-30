define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fields-toggle' ).reply( 'update:setting', this.updateSetting, this );
		},

		updateSetting: function( fieldModel, name, value, e ) {
			if ( jQuery( e.target ).attr( 'checked' ) ) {
				var value = 1;
			} else {
				var value = 0;
			}

			fieldModel.set( name, value );
			
			return true;
		}

	});

	return controller;
} );