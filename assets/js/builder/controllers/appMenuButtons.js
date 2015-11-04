define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'click:publish', this.publish );
			this.listenTo( nfRadio.channel( 'app' ), 'click:viewChanges', this.viewChanges );

			this.listenTo( nfRadio.channel( 'app' ), 'response:updateDB', this.publishResponse );

		},

		publish: function() {
			nfRadio.channel( 'app' ).request( 'update:db', 'publish' );
		},



		publishResponse: function( response ) {
			if ( 'publish' !== response.action ) {
				return false;
			}
			
			if ( 'undefined' != typeof response.data.new_ids ) {
				if ( 'undefined' != typeof response.data.new_ids.fields ) {
					_.each( response.data.new_ids.fields, function( newID, oldID ) {
						var field = nfRadio.channel( 'data' ).request( 'get:field', oldID );
						if ( field ) {
							field.set( 'id', newID );
						}
					} );
				}
			}

			nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', true );
		},

		viewChanges: function() {
			nfRadio.channel( 'app' ).request( 'open:drawer', 'viewChanges', { collection: nfUndoManager.stack } );
		}

	});

	return controller;
} );