define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'update:setting', this.setAppClean, this );
		},

		setAppClean: function( fieldModel ) {
			nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', false );
		}

	});

	return controller;
} );