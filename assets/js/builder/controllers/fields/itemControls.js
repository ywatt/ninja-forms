/**
 * Listens for clicks on our field item action buttons.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - Main Sortable
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Listen for clicks to edit, delete, duplicate fields.
			this.listenTo( nfRadio.channel( 'fields' ), 'click:editField', this.clickEdit );
			this.listenTo( nfRadio.channel( 'fields' ), 'click:deleteField', this.clickDelete );
			this.listenTo( nfRadio.channel( 'fields' ), 'click:duplicateField', this.clickDuplicate );

			// Listen for our drawer close and remove our active edit state
		},

		/**
		 * Open a drawer with our field model for editing settings.
		 * 
		 * @since  3.0
		 * @param  Object			e     	event
		 * @param  backbone.model 	model 	field model
		 * @return void
		 */
		clickEdit: function( e, model ) {
			nfRadio.channel( 'fields' ).request( 'clear:editActive' );
			model.set( 'editActive', true );
			nfRadio.channel( 'app' ).request( 'open:drawer', 'editField', { model: model } );
		},

		/**
		 * Delete a field model from our collection
		 * 
		 * @since  3.0
		 * @param  Object			e     	event
		 * @param  backbone.model 	model 	field model
		 * @return void
		 */
		clickDelete: function( e, model ) {
			nfRadio.channel( 'fields' ).request( 'delete:field', model );
		},

		/**
		 * Duplicate a field within our collection, adding the word "copy" to the label.
		 * 
		 * @since  3.0
		 * @param  Object			e     	event
		 * @param  backbone.model 	model 	field model
		 * @return void
		 */
		clickDuplicate: function( e, model ) {
			var newModel = model.clone();
			var tmpID = nfRadio.channel( 'fields' ).request( 'get:tmpFieldID' );
			newModel.set( 'id', tmpID );
			var newLabel = newModel.get( 'label' ) + ' Copy';
			newModel.set( 'label', newLabel );
			nfRadio.channel( 'fields' ).request( 'add:field', newModel );
			nfRadio.channel( 'app' ).request( 'update:db' );
		}

	});

	return controller;
} );