/**
 * Track settings changes across our app.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/app/changeCollection', 'builder/models/app/changeModel'], function( changeCollection, ChangeModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.collection = new changeCollection();
			// Respond to any requests to add a change directly.
			nfRadio.channel( 'changes' ).reply( 'register:change', this.registerChange, this );
			// Respond to requests for the change collection
			nfRadio.channel( 'changes' ).reply( 'get:changeCollection', this.getCollection, this );
		},

		registerChange: function( action, model, changes, label, data ) {
			var data = typeof data !== 'undefined' ? data : {};
			var changeModel = new ChangeModel({
				action: action,
				model: model,
				changes: changes,
				label: label,
				data: data				
			} );
			this.collection.add( changeModel );
			return changeModel;
		},

		getCollection: function() {
			return this.collection;
		}

	});

	return controller;
} );