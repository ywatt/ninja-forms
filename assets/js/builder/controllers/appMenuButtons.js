define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'click:publish', this.publish );
			this.listenTo( nfRadio.channel( 'app' ), 'click:cancelChanges', this.cancelChanges );
		},

		publish: function() {
			console.log( 'publish changes' );
			nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', true );
		},

		cancelChanges: function() {
			nfRadio.channel( 'app' ).request( 'open:drawer', 'viewChanges', nfUndoManager.stack );
			// nfRadio.channel( 'data' ).request( 'cancel:changes' );
			// nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', true );
		}

	});

	return controller;
} );