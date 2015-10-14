define( ['builder/models/appModel'], function( appModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			appDomainCollection.get( 'fields' ).set( 'active', true );
			this.model = new appModel( {
				currentDomain: appDomainCollection.get( 'fields' )
			} );
			nfRadio.channel( 'app' ).reply( 'update:appDomain', this.updateDomain, this );
			nfRadio.channel( 'app' ).reply( 'get:appData', this.getAppData, this );
			nfRadio.channel( 'app' ).reply( 'get:currentDomain', this.getCurrentDomain, this );
		},

		updateDomain: function( model ) {
			this.model.set( 'currentDomain', model );
			nfRadio.channel( 'app' ).trigger( 'change:domain', model );
			return true;
		},

		getAppData: function() {
			return this.model;
		},

		getCurrentDomain: function() {
			return this.model.get( 'currentDomain' );
		}


	});

	return controller;
} );