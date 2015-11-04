define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:cancelChanges', this.cancelChanges, this );
		},

		cancelChanges: function() {
			nfUndoManager.undoAll();
			nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', true );
			nfRadio.channel( 'app' ).trigger( 'cancel:changes' );
			nfRadio.channel( 'app' ).request( 'close:drawer' );
		}

	});

	return controller;
} );