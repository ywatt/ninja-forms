define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'before:postChanges', this.disablePreview );
			this.listenTo( nfRadio.channel( 'app' ), 'response:postChanges', this.changePreviewNicename );
		},

		disablePreview: function() {
			var appDomains = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var preview = appDomains.get( 'preview' );
			preview.set( 'disabled', true );
		},

		changePreviewNicename: function() {
			var appDomains = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var preview = appDomains.get( 'preview' );
			preview.set( 'nicename', 'Preview Changes' );
			preview.set( 'disabled', false );
		}

	});

	return controller;
} );