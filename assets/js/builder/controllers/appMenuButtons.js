define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'click:publish', this.publish );
			this.listenTo( nfRadio.channel( 'app' ), 'click:viewChanges', this.viewChanges );
		},

		publish: function() {
			if ( nfRadio.channel( 'app' ).request( 'get:appSetting', 'clean' ) ) {
				return false;
			}
			
			var formData = nfRadio.channel( 'data' ).request( 'get:formData' );
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

			nfRadio.channel( 'app' ).trigger( 'before:sendChanges', data );
			jQuery.post( ajaxurl, { action: 'nf_save_form', form: data, security: nfAdmin.ajaxNonce }, function( response ) {
				response = JSON.parse( response );
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
				nfRadio.channel( 'app' ).trigger( 'response:sendChanges', response );
				nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', true );
			} );
			
		},

		viewChanges: function() {
			nfRadio.channel( 'app' ).request( 'open:drawer', 'viewChanges', { collection: nfUndoManager.stack } );
		}

	});

	return controller;
} );