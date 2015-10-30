define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fields-toggle' ).reply( 'before:updateSetting', this.updateSetting, this );
		},

		updateSetting: function( e, fieldModel, name, settingTypeModel ) {
			if ( jQuery( e.target ).attr( 'checked' ) ) {
				var value = 1;
			} else {
				var value = 0;
			}

			return value;
		}

	});

	return controller;
} );