/**
 * Stores our form data and responds to requests for it.
 * Form data stores fields, actions, and settings.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['models/app/formModel'], function( formModel) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Instantiate Form Model
			this.model = new formModel;
			// Set our form ID
			this.model.set( 'id', preloadedFormData.id );
			// Set our field collection
			this.model.set( 'fields', nfRadio.channel( 'fields' ).request( 'get:collection' ) );
			// Set our actions collection
			this.model.set( 'actions', nfRadio.channel( 'actions' ).request( 'get:collection' ) );
			// TODO: Set our settings collection
			this.model.set( 'settings', preloadedFormData.settings );
			// Respond to requests for form data.
			nfRadio.channel( 'app' ).reply( 'get:formData', this.getFormData, this );
		},

		/**
		 * Return form data model.
		 * 
		 * @since  3.0
		 * @return backbone.model
		 */
		getFormData: function() {
			return this.model;
		}

	});

	return controller;
} );