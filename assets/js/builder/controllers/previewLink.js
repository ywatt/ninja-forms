define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'before:sendChanges', this.disablePreview, this );
			this.listenTo( nfRadio.channel( 'app' ), 'response:sendChanges', this.enablePreview, this );
			this.listenTo( nfRadio.channel( 'app' ), 'change:clean', this.changePreviewNicename, this );
		},

		disablePreview: function() {
			var appDomains = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var preview = appDomains.get( 'preview' );
			preview.set( 'disabled', true );
		},

		changePreviewNicename: function( status ) {
			var appDomains = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var preview = appDomains.get( 'preview' );

			if ( ! status ) {
				var nicename = 'Preview Changes';
			} else {
				var nicename = 'Preview Form';
			}

			preview.set( 'nicename', nicename );
		},

		enablePreview: function() {
			var appDomains = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var preview = appDomains.get( 'preview' );
			preview.set( 'disabled', false );
		}

	});

	return controller;
} );