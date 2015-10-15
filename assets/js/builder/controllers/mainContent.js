define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'app' ).reply( 'get:mainContentView', this.getMainContentView, this );
		},

		getMainContentView: function() {
			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
			
		}

	});

	return controller;
} );