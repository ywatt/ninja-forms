define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:undoChanges', this.undoChanges, this );
		},

		undoChanges: function() {
			// nfUndoManager.undoAll();
			var field = nfRadio.channel( 'fields' ).request( 'get:field', 1 );
			nfUndoManager.undo( field );


			nfRadio.channel( 'fields' ).request( 'update:removedIDs' );
			nfRadio.channel( 'fields' ).request( 'update:newIDs' );
			nfRadio.channel( 'app' ).request( 'update:db' );
			nfRadio.channel( 'app' ).request( 'update:setting', 'clean', true );
			nfRadio.channel( 'app' ).trigger( 'cancel:changes' );
			nfRadio.channel( 'app' ).request( 'close:drawer' );
		}

	});

	return controller;
} );