define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'closed', this.updateDB );
			nfRadio.channel( 'app' ).reply( 'update:db', this.updateDB, this );
		},

		updateDB: function( action ) {
			if ( nfRadio.channel( 'app' ).request( 'get:setting', 'clean' ) ) {
				return false;
			}
			
			action = action || 'preview';

			if ( 'preview' == action ) {
				var jsAction = 'nf_preview_update';
			} else if ( 'publish' == action ) {
				var jsAction = 'nf_save_form';
			}
			var formData = nfRadio.channel( 'app' ).request( 'get:formData' );
			removedIDs = formData.get( 'fields' ).removedIDs;

			var data = JSON.parse( JSON.stringify( formData ) );

			_.each( data.fields, function( field ) {
				var id = field.id;
				delete field.id;
				delete field.parent_id;
				var settings = {};
				for (var prop in field) {
				    if ( field.hasOwnProperty( prop ) ) {
				        settings[ prop ] = field[ prop ];
				        delete field[ prop ];
				    }
				}
				field.settings = settings;
				field.id = id;
			} );

			data.deleted_fields = removedIDs;

			data = JSON.stringify( data );

			nfRadio.channel( 'app' ).trigger( 'before:updateDB', data );
			jQuery.post( ajaxurl, { action: jsAction, form: data, security: nfAdmin.ajaxNonce }, function( response ) {
				response = JSON.parse( response );
				response.action = action;
				nfRadio.channel( 'app' ).trigger( 'response:updateDB', response );
			} );
		}

	});

	return controller;
} );