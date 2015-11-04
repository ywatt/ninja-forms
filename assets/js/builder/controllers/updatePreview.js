define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'close:drawer', this.updatePreview );
			nfRadio.channel( 'app' ).reply( 'update:preview', this.updatePreview, this );
		},

		updatePreview: function() {
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
			console.log( data );
			data = JSON.stringify( data );

			nfRadio.channel( 'app' ).trigger( 'before:sendChanges', data );
			jQuery.post( ajaxurl, { action: 'nf_preview_update', form: data, security: nfAdmin.ajaxNonce }, function( response ) {
				nfRadio.channel( 'app' ).trigger( 'response:sendChanges', response );
			} );
		}

	});

	return controller;
} );