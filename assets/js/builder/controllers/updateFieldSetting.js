define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'update:setting', this.updateSetting, this );
		},

		updateSetting: function( fieldModel ) {
			// Update our model in the database.
			var changedSettings = fieldModel.changedAttributes();
			var fieldID = fieldModel.get( 'id' );
			var formID = preloadedFormData.id;
			var data = {
				id: formID,
				fields: [
					{
						id: fieldID,
						settings: changedSettings
					}
				]
			}
			
			data = JSON.stringify( data );
			
			jQuery.post( ajaxurl, { action: 'nf_preview_update', form: data, security: nfAdmin.ajaxNonce }, function( response ) {
				console.log( jQuery.parseJSON( response ) );
			} );
		}

	});

	return controller;
} );