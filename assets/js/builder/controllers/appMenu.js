define( ['builder/models/appMenuCollection'], function( appMenuCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new appMenuCollection( [
				{ id: 'fields', nicename: 'Form Fields' },
				{ id: 'actions', nicename: 'Emails & Actions' },
				{ id: 'settings', nicename: 'Settings' },
				{ id: 'preview', nicename: 'Preview Changes', classes: 'preview', dashicons: 'dashicons-visibility' }
			] );

			nfRadio.channel( 'app' ).reply( 'get:appMenuCollection', this.getAppMenuCollection, this );
			this.listenTo( nfRadio.channel( 'app' ), 'click:appMenu', this.changeAppChannel );
		},

		getAppMenuCollection: function() {
			return this.collection;
		},

		changeAppChannel: function( model ) {
			console.log( model.get( 'nicename' ) );
		}

	});

	return controller;
} );