define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields-toggle' ), 'change:setting', this.changeSetting );
		},

		changeSetting: function( e, fieldTypeModel, fieldModel ) {
			if ( jQuery( e.target ).attr( 'checked' ) ) {
				var value = 1;
			} else {
				var value = 0;
			}

			fieldModel.set( fieldTypeModel.get( 'name' ), value );
			fieldModel.set( 'isUpdated', true );
		}

	});

	return controller;
} );