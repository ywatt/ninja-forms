define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'change:setting', this.changeSetting, this );
		},

		changeSetting: function( e, settingTypeModel, fieldModel ) {
			var value = jQuery( e.target ).val();
			var name = settingTypeModel.get( 'name' );
			nfRadio.channel( 'fields' ).request( 'update:setting', fieldModel, name, value, settingTypeModel, e );
		}

	});

	return controller;
} );