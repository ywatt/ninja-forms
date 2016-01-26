/**
 * If we add a saved field to our form and then update it, set the "isSaved" flag to false.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		ignoreAttributes: [
			'editActive',
			'order'
		],

		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'update:setting', this.updateField );
			// Listen to clicks on our add saved field button.
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:addSavedField', this.clickAddSavedField, this );
		},

		updateField: function( dataModel ) {
			if ( dataModel.get( 'isSaved' ) ) {
				
				var modified = false;
				var changedAttributes = _.keys( dataModel.changedAttributes() );
				var that = this;
				_.each( changedAttributes, function( changed ) {
					if ( -1 == that.ignoreAttributes.indexOf( changed ) ) {
						modified = true;
					}
				} );
				
				if ( modified ) {
					dataModel.set( 'isSaved', false );
				}
			}
		},

		clickAddSavedField: function( e, dataModel ) {
			var fieldData = dataModel.toJSON();
			delete fieldData.jBox;

			jQuery.post( ajaxurl, { action: 'nf_create_saved_field', field: fieldData, security: nfAdmin.ajaxNonce }, function( response ) {
				try {
					console.log( response );
				} catch( exception ) {
					console.log( 'Something went wrong!' );
					console.log( response );
				}
				
			} );
			dataModel.get( 'jBox' ).close();
		}
	});

	return controller;
} );