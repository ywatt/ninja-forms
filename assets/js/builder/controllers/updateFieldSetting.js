define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'update:setting', this.updateSetting, this );
		},

		updateSetting: function( e, settingTypeModel, fieldModel ) {
			// Update our model in the database.
			// var data = this.changedAttributes();
			// data.fieldID = this.get( 'id' );
			var appData = nfRadio.channel( 'app' ).request( 'get:appData' );

			
		}

	});

	return controller;
} );