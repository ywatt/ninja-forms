define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:undoChanges', this.undoChanges, this );
		},

		undoChanges: function() {
			// nfUndoManager.undoAll();
			var field = nfRadio.channel( 'data' ).request( 'get:field', 1 );
			nfUndoManager.undo( field );


			nfRadio.channel( 'data' ).request( 'update:removedIDs' );
			nfRadio.channel( 'data' ).request( 'update:newIDs' );
			nfRadio.channel( 'app' ).request( 'update:db' );
			nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', true );
			nfRadio.channel( 'app' ).trigger( 'cancel:changes' );
			nfRadio.channel( 'app' ).request( 'close:drawer' );
		}

	});

	return controller;
} );