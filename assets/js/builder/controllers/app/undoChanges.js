define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:undoChanges', this.undoChanges, this );
		},

		undoChanges: function() {
			var changeCollection = nfRadio.channel( 'undo' ).request( 'get:changeCollection' );
			changeCollection.sort();
			_.each( changeCollection.models, function( model ) {
				var attr = model.get( 'attr' );
				var before = model.get( 'before' );
				var after = model.get( 'after' );
				var objModel = model.get( 'model' );

				objModel.set( attr, before );
			} );
			nfRadio.channel( 'app' ).request( 'close:drawer' );
			changeCollection.reset();
		}

	});

	return controller;
} );