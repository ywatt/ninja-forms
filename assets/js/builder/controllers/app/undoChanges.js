define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:undoAllChanges', this.undoAllChanges, this );
			nfRadio.channel( 'changes' ).reply( 'undo:single', this.undoSingle, this );
		},

		undoAllChanges: function() {
			var changeCollection = nfRadio.channel( 'changes' ).request( 'get:changeCollection' );
			changeCollection.sort();
			_.each( changeCollection.models, function( model ) {
				this.undoSingle( model );
			} );
			nfRadio.channel( 'app' ).request( 'close:drawer' );
			changeCollection.reset();
		},

		undoSingle: function( model ) {
			var attr = model.get( 'attr' );
			var before = model.get( 'before' );
			var after = model.get( 'after' );
			var objModel = model.get( 'model' );
			objModel.set( attr, before );
			model.collection.remove( model );
		}

	});

	return controller;
} );