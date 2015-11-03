define( ['builder/models/appModel'], function( appModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			this.model = new appModel( {
				currentDrawer: false,
				currentDomain: appDomainCollection.get( 'fields' ),
				clean: true
			} );

			nfRadio.channel( 'app' ).reply( 'update:appDomain', this.updateDomain, this );
			nfRadio.channel( 'app' ).reply( 'update:currentDrawer', this.updateCurrentDrawer, this );
			nfRadio.channel( 'app' ).reply( 'update:appSetting', this.updateSetting, this );

			nfRadio.channel( 'app' ).reply( 'get:appData', this.getAppData, this );
			nfRadio.channel( 'app' ).reply( 'get:appSetting', this.getAppSetting, this );
			nfRadio.channel( 'app' ).reply( 'get:currentDomain', this.getCurrentDomain, this );
			nfRadio.channel( 'app' ).reply( 'get:currentDrawer', this.getCurrentDrawer, this );
		},

		updateDomain: function( model ) {
			this.updateSetting( 'currentDomain', model );
		},

		updateSetting: function( setting, value ) {
			this.model.set( setting, value );
			return true;
		},

		getAppSetting: function( setting ) {
			return this.model.get( setting );
		},

		getAppData: function() {
			return this.model;
		},

		getCurrentDomain: function() {
			return this.model.get( 'currentDomain' );
		},

		updateCurrentDrawer: function( drawerID ) {
			this.updateSetting( 'currentDrawer', drawerID );
			return true;
		},

		getCurrentDrawer: function() {
			return this.model.get( 'currentDrawer' );
		}


	});

	return controller;
} );