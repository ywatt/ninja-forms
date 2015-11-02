define( [
	'builder/models/appDomainCollection',
	'builder/views/mainContentFieldCollection',
	'builder/views/mainContentActions',
	'builder/views/mainContentSettings',
	'builder/views/mainHeaderFields',
	'builder/views/mainHeaderActions',
	'builder/views/mainHeaderSettings',
	'builder/views/subHeaderFields',
	'builder/views/subHeaderActions',
	'builder/views/subHeaderSettings',

	], 
	function( 
		appDomainCollection,
		mainContentFieldsView,
		mainContentActionsView,
		mainContentSettingsView,
		mainHeaderFieldsView,
		mainHeaderActionsView,
		mainHeaderSettingsView,
		subHeaderFieldsView,
		subHeaderActionsView,
		subHeaderSettingsView
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			var that = this;

			this.collection = new appDomainCollection( [
				{
					id: 'fields',
					nicename: 'Form Fields',
					hotkeys: {
						'Ctrl+Shift+n': 'add:newField',
						'Ctrl+Shift+a': 'changeDomain:actions',
						'Ctrl+Shift+s': 'changeDomain:settings'
					},

					getMainHeaderView: function() {
						return new mainHeaderFieldsView();
					},

					getSubHeaderView: function() {
						return new subHeaderFieldsView();
					},

					getMainContentView: function( collection ) {
						var collection = nfRadio.channel( 'data' ).request( 'get:fieldCollection' );
						return new mainContentFieldsView( { collection: collection } );
					}
				},
				{
					id: 'actions',
					nicename: 'Emails & Actions',
					hotkeys: {
						'Ctrl+Shift+n': 'add:newAction',
						'Ctrl+Shift+f': 'changeDomain:fields',
						'Ctrl+Shift+s': 'changeDomain:settings'
					},

					getMainHeaderView: function() {
						return new mainHeaderActionsView();
					},

					getSubHeaderView: function() {
						return new subHeaderActionsView();
					},
					
					getMainContentView: function() {
						return new mainContentActionsView();
					}
				},
				{
					id: 'settings',
					nicename: 'Settings',
					hotkeys: {
						'Ctrl+Shift+f': 'changeDomain:fields',
						'Ctrl+Shift+a': 'changeDomain:actions'
					},

					getMainHeaderView: function() {
						return new mainHeaderSettingsView();
					},

					getSubHeaderView: function() {
						return new subHeaderSettingsView();
					},
					
					getMainContentView: function() {
						return new mainContentSettingsView();
					}
				},
				{
					id: 'preview',
					nicename: 'Preview Form',
					classes: 'preview',
					dashicons: 'dashicons-visibility',
					url: nfAdmin.previewurl
				}
			] );

			nfRadio.channel( 'app' ).reply( 'get:appDomainCollection', this.getAppDomainCollection, this );
			nfRadio.channel( 'app' ).reply( 'change:appDomain', this.changeAppDomain, this );

			this.listenTo( nfRadio.channel( 'app' ), 'click:appMenu', this.changeAppDomain );
			this.listenTo( nfRadio.channel( 'app' ), 'click:changeDomain', this.maybeChangeDomain );
		},

		getAppDomainCollection: function() {
			return this.collection;
		},

		changeAppDomain: function( model ) {

			nfRadio.channel( 'app' ).request( 'close:drawer' );
						
			if ( 0 == model.get( 'url' ).length ) {
				var updated = nfRadio.channel( 'app' ).request( 'update:appDomain', model );
				nfRadio.channel( 'app' ).trigger( 'change:appDomain', model );
			}
		},

		maybeChangeDomain: function( e ) {
			var domainID = jQuery( e.target ).data( 'domain' );
			var domainModel = this.collection.get( domainID );
			this.changeAppDomain( domainModel );
		}

	});

	return controller;
} );