/**
 * Handles interactions with our actions collection.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - New Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/actions/actionCollection', 'builder/models/actions/actionModel'], function( actionCollection, actionModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Load our field collection from our localized form data
			this.collection = new actionCollection( preloadedFormData.actions );
			// Set our removedIDs to an empty object. This will be populated when a field is removed so that we can add it to our 'deleted_fields' object.
			this.collection.removedIDs = {};

			// Respond to requests for data about fields and to update/change/delete fields from our collection.
			nfRadio.channel( 'actions' ).reply( 'get:collection', this.getCollection, this );
			nfRadio.channel( 'actions' ).reply( 'get:collection', this.getCollection, this );
			nfRadio.channel( 'actions' ).reply( 'get:action', this.getAction, this );
			nfRadio.channel( 'actions' ).reply( 'get:tmpID', this.getTmpID, this );

			nfRadio.channel( 'actions' ).reply( 'add', this.addAction, this );
			nfRadio.channel( 'actions' ).reply( 'delete:action', this.deleteAction, this );
			nfRadio.channel( 'actions' ).reply( 'delete', this.deleteAction, this );
			// nfRadio.channel( 'fields' ).reply( 'sort:fields', this.sortFields, this );
			
			// nfRadio.channel( 'fields' ).reply( 'update:removedIDs', this.updateRemovedIDs, this );
			// nfRadio.channel( 'fields' ).reply( 'update:newIDs', this.updateRemovedIDs, this );
		},

		getCollection: function() {
			return this.collection;
		},

		getAction: function( id ) {
			return this.collection.get( id );
		},

		/**
		 * Add a field to our collection. If silent is passed as true, no events will trigger.
		 * 
		 * @since 3.0
		 * @param Object 	data 	field data to insert
		 * @param bool 		silent 	prevent events from firing as a result of adding	 	
		 */
		addAction: function( data, silent ) {
			silent = silent || false;
			if ( false === data instanceof Backbone.Model ) {
				var model = new actionModel( data );
			} else {
				var model = data;
			}

			this.collection.add( model, { silent: silent } );
			// Set our 'clean' status to false so that we get a notice to publish changes
			nfRadio.channel( 'app' ).request( 'update:setting', 'clean', false );

			return model;
		},

		/**
		 * Delete a field from our collection.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	field model to be deleted
		 * @return void
		 */
		deleteAction: function( model ) {
			this.collection.remove( model );
			// Set our 'clean' status to false so that we get a notice to publish changes
			nfRadio.channel( 'app' ).request( 'update:setting', 'clean', false );
			nfRadio.channel( 'app' ).request( 'update:db' );

		},

		/**
		 * Compare our list of current fields with our new ids to see if any new IDs were removed.
		 * 
		 * @since  3.0
		 * @return {[type]} [description]
		 */
		updateRemovedIDs: function() {
			this.collection.removedIDs = {};
			if ( 0 < this.collection.newIDs.length ) {
				var that = this;
				// Loop through our new fields and see if any have been removed.
				_.each( this.collection.newIDs, function( id ) {
					if ( ! that.collection.get( id ) ) {
						that.collection.removedIDs[ id ] = id;
					}
				} );
			}
		},

		/**
		 * Return a new tmp id for our fields.
		 * Gets the field collection length, adds 1, then returns that prepended with 'tmp-'.
		 * 
		 * @since  3.0
		 * @return string
		 */
		getTmpID: function() {
			var tmpNum = this.collection.tmpNum;
			this.collection.tmpNum++;
			return 'tmp-' + tmpNum;
		}
	});

	return controller;
} );