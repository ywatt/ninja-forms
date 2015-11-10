define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:undoChanges', this.undoChanges, this );
		},

		undoChanges: function() {

		}

	});

	return controller;
} );