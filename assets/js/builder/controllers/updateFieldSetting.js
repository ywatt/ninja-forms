define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fields' ).reply( 'update:setting', this.updateSetting, this );
		},

		updateSetting: function( fieldModel, name, value, settingTypeModel, e ) {

			/*
			 * Send out a message saying that we've changed a field.
			 *
			 * If the submitted value you wish to store in the data model isn't the same as the value received above,
			 * you can set that model in the actions below and set the 'isUpdated' model attribute to true.
			 * i.e. model.set( 'isUpdated', true );
			 */
			
			var customUpdate = nfRadio.channel( 'fields-' + settingTypeModel.get( 'type' ) ).request( 'update:setting', fieldModel, name, value, e );

			if ( customUpdate ) {
				return false;
			}

			nfRadio.channel( 'data' ).request( 'update:fieldSetting', fieldModel.get( 'id' ), name, value );
		}

	});

	return controller;
} );