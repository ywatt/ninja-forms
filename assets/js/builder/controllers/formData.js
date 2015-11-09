/**
 * Stores our form data
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/formModel'], function( formModel) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.model = new formModel;
			this.model.set( 'id', preloadedFormData.id );
			this.model.set( 'fields', nfRadio.channel( 'fields' ).request( 'get:fieldCollection' ) );
			this.model.set( 'settings', preloadedFormData.settings );

			nfRadio.channel( 'app' ).reply( 'get:formData', this.getFormData, this );
		},

		getFormData: function() {
			return this.model;
		}

	});

	return controller;
} );