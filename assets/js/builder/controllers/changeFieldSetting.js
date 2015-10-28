define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fields' ).reply( 'change:setting', this.changeSetting, this );
		},

		changeSetting: function( e, fieldTypeModel, fieldModel ) {
			// Get our current value.
			var value = jQuery( e.target ).val();
			
			// Set our 'isUpdated' flag to false.
			fieldModel.set( 'isUpdated', false );

			/*
			 * Send out a message saying that we've changed a field.
			 *
			 * If the submitted value you wish to store in the data model isn't the same as the value received above,
			 * you can set that model in the actions below and set the 'isUpdated' model attribute to true.
			 * i.e. model.set( 'isUpdated', true );
			 */
			
			nfRadio.channel( 'fields-' + fieldTypeModel.get( 'type' ) ).trigger( 'change:setting', e, fieldTypeModel, fieldModel );

			if ( ! fieldModel.get( 'isUpdated' ) ) {
				fieldModel.set( fieldTypeModel.get( 'name' ), value );
				fieldModel.set( 'isUpdated', true );
			}
		}

	});

	return controller;
} );