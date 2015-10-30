define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'change:setting', this.changeSetting, this );
		},

		changeSetting: function( e, settingTypeModel, fieldModel ) {
			var name = settingTypeModel.get( 'name' );
			var value = nfRadio.channel( 'fields-' + settingTypeModel.get( 'type' ) ).request( 'before:updateSetting', e, fieldModel, name, settingTypeModel );
			if ( 'undefined' == typeof value ) {
				value = jQuery( e.target ).val();
			}

			fieldModel.set( name, value );
		}

	});

	return controller;
} );