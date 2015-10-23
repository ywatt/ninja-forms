define( ['builder/models/appModel'], function( appModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			appDomainCollection.get( 'fields' ).set( 'active', true );
			this.model = new appModel( {
				currentDrawer: false,
				currentDomain: appDomainCollection.get( 'fields' )
			} );

			nfRadio.channel( 'app' ).reply( 'update:appDomain', this.updateDomain, this );
			nfRadio.channel( 'app' ).reply( 'update:currentDrawer', this.updateCurrentDrawer, this );
			nfRadio.channel( 'app' ).reply( 'get:appData', this.getAppData, this );
			nfRadio.channel( 'app' ).reply( 'get:currentDomain', this.getCurrentDomain, this );
			nfRadio.channel( 'app' ).reply( 'get:currentDrawer', this.getCurrentDrawer, this );
		},

		updateDomain: function( model ) {
			this.model.set( 'currentDomain', model );
			return true;
		},

		getAppData: function() {
			return this.model;
		},

		getCurrentDomain: function() {
			return this.model.get( 'currentDomain' );
		},

		updateCurrentDrawer: function( drawerID ) {
			this.model.set( 'currentDrawer', drawerID );
			return true;
		},

		getCurrentDrawer: function() {
			return this.model.get( 'currentDrawer' );
		}


	});

	return controller;
} );