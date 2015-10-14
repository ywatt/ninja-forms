define( ['builder/models/appDomainCollection', 'builder/views/mainFields', 'builder/views/mainActions', 'builder/views/mainSettings'], function( appDomainCollection, mainFieldsView, mainActionsView, mainSettingsView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new appDomainCollection( [
				{
					id: 'fields',
					nicename: 'Form Fields',

					getView: function() {
						return new mainFieldsView();
					}
				},
				{
					id: 'actions',
					nicename: 'Emails & Actions',

					getView: function() {
						return new mainActionsView();
					}
				},
				{
					id: 'settings',
					nicename: 'Settings',

					getView: function() {
						return new mainSettingsView();
					}
				},
				{
					id: 'preview',
					nicename: 'Preview Changes',
					classes: 'preview',
					dashicons: 'dashicons-visibility',
					url: 'http://www.cnn.com'
				}
			] );

			nfRadio.channel( 'app' ).reply( 'get:appDomainCollection', this.getAppDomainCollection, this );
			this.listenTo( nfRadio.channel( 'app' ), 'click:appMenu', this.changeAppDomain );
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
		}

	});

	return controller;
} );