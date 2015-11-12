/**
 * Track settings changes across our app.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/app/changeCollection'], function( changeCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			/*
			 * Set an array of field model attributes to ignore.
			 * This list will be filtered just before we ignore anything.
			 */ 
			this.ignoreAttributes = [
				'editActive'
			];

			this.collection = new changeCollection();
			// Respond to any requests to add a change directly.
			nfRadio.channel( 'changes' ).reply( 'register:change', this.registerChange, this );
			// Respond to requests for the change collection
			nfRadio.channel( 'changes' ).reply( 'get:changeCollection', this.getCollection, this );
		},

		registerChange: function( action, objModels, label, dashicon ) {
			this.collection.add( {
				action: action,
				objModels: objModels,
				label: label,
				dashicon: dashicon
			} );
		},

		getCollection: function() {
			return this.collection;
		}

	});

	return controller;
} );