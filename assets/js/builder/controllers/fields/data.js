/**
 * Handles interactions with our field collection.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - New Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/fieldCollection'], function( fieldCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Load our field collection from our localized form data
			this.collection = new fieldCollection( preloadedFormData.fields );
			// Set our removedIDs to an empty object. This will be populated when a field is removed so that we can add it to our 'deleted_fields' object.
			this.collection.removedIDs = {};

			// Respond to requests for data about fields and to update/change/delete fields from our collection.
			nfRadio.channel( 'fields' ).reply( 'get:fieldCollection', this.getFieldCollection, this );
			nfRadio.channel( 'fields' ).reply( 'get:field', this.getField, this );
			nfRadio.channel( 'fields' ).reply( 'get:tmpFieldID', this.getTmpFieldID, this );

			nfRadio.channel( 'fields' ).reply( 'add:field', this.addField, this );
			nfRadio.channel( 'fields' ).reply( 'delete:field', this.deleteField, this );
			nfRadio.channel( 'fields' ).reply( 'sort:fields', this.sortFields, this );
			
			nfRadio.channel( 'fields' ).reply( 'update:removedIDs', this.updateRemovedIDs, this );
			nfRadio.channel( 'fields' ).reply( 'update:newIDs', this.updateRemovedIDs, this );
		},

		getFieldCollection: function() {
			return this.collection;
		},

		getField: function( id ) {
			return this.collection.get( id );
		},

		/**
		 * Add a field to our collection. If silent is passed as true, no events will trigger.
		 * 
		 * @since 3.0
		 * @param Object 	data 	field data to insert
		 * @param bool 		silent 	prevent events from firing as a result of adding	 	
		 */
		addField: function( data, silent ) {
			silent = silent || false;
			this.collection.add( data, { silent: silent } );
			// Set our 'clean' status to false so that we get a notice to publish changes
			nfRadio.channel( 'app' ).request( 'update:setting', 'clean', false );
		},

		/**
		 * Update a field setting by ID
		 * 
		 * @since  3.0
		 * @param  int 		id    field id
		 * @param  string 	name  setting name
		 * @param  mixed 	value setting value
		 * @return void
		 */
		updateFieldSetting: function( id, name, value ) {
			var fieldModel = this.collection.get( id );
			fieldModel.set( name, value );
		},

		/**
		 * Get our fields sortable EL
		 * 
		 * @since  3.0
		 * @param  Array 	order optional order array like: [field-1, field-4, field-2]
		 * @return void
		 */
		sortFields: function( order ) {
			// Get our sortable element
			var sortableEl = nfRadio.channel( 'fields' ).request( 'get:sortableEl' );
			if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) { // Make sure that sortable is enabled
				// JS ternerary for setting our order
				var order = order || jQuery( sortableEl ).sortable( 'toArray' );
				// Loop through all of our fields and update their order value
				_.each( this.collection.models, function( field ) {
					var id = field.get( 'id' );
					if ( jQuery.isNumeric( id ) ) {
						var search = 'field-' + id;
					} else {
						var search = id;
					}
					// Get the index of our field inside our order array
					var pos = order.indexOf( search ) + 1;
					field.set( 'order', pos );
				} );
				this.collection.sort();
				// Set our 'clean' status to false so that we get a notice to publish changes
				nfRadio.channel( 'app' ).request( 'update:setting', 'clean', false );
				// Update our preview
				nfRadio.channel( 'app' ).request( 'update:db' );
			}
		},

		/**
		 * Delete a field from our collection.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	field model to be deleted
		 * @return void
		 */
		deleteField: function( model ) {
			this.collection.remove( model );
			// Set our 'clean' status to false so that we get a notice to publish changes
			nfRadio.channel( 'app' ).request( 'update:setting', 'clean', false );
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
		getTmpFieldID: function() {
			var tmpNum = this.collection.models.length + 1;
			return 'tmp-' + tmpNum;
		}
	});

	return controller;
} );