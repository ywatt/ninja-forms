/**
 * Our undo manager. Currently only changes the 'clean' state of our app when the field model changes.
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
			// Listen for the field setting update event.
			this.listenTo( nfRadio.channel( 'fields' ), 'update:setting', this.changeSetting );
			// Respond to any requests to add a change directly.
			this.listenTo( nfRadio.channel( 'undo' ), 'register:change', this.registerChange );
			// Respond to requests for the change collection
			nfRadio.channel( 'undo' ).reply( 'get:changeCollection', this.getCollection, this );
		},

		/**
		 * When we hear an updated field setting event, check it's changed attribute against our ignore list.
		 * If it's not found, register the change.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	updated field model
		 * @return void
		 */
		changeSetting: function( model ) {
			for( var attr in model.changedAttributes() ) {
				var changedAttr = attr;
				var after = model.changedAttributes()[ attr ];
			}

			var ignoreAttributes = nfRadio.channel( 'undo-' + model.get( 'type' ) ).request( 'ignore:attributes', this.ignoreAttributes ) || this.ignoreAttributes;

			if ( -1 != this.ignoreAttributes.indexOf( attr ) ) {
				return false;
			}

			if ( 'undefined' == typeof model._previousAttributes[ attr ] ) {
				var before = null;
			} else {
				var before = model._previousAttributes[ attr ];
			}

			this.registerChange( 'changeSetting', model, attr, before, after );
		},

		registerChange: function( action, model, attr, before, after ) {
			this.collection.add( { action: action, model: model, attr: attr, before: before, after: after } );
		},

		getCollection: function() {
			return this.collection;
		}

	});

	return controller;
} );