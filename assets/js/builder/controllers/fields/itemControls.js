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
			var type = nfRadio.channel( 'fields' ).request( 'get:type' , model.get( 'type' ) );
			nfRadio.channel( 'app' ).request( 'open:drawer', 'editSettings', { model: model, groupCollection: type.get( 'settingGroups' ) } );
		},

		/**
		 * Delete a field model from our collection
		 * 
		 * @since  3.0
		 * @param  Object			e     	event
		 * @param  backbone.model 	model 	field model
		 * @return void
		 */
		clickDelete: function( e, fieldModel ) {
			var newModel = nfRadio.channel( 'app' ).request( 'clone:modelDeep', fieldModel );

			// Add our field deletion to our change log.
			var label = {
				object: 'Field',
				label: fieldModel.get( 'label' ),
				change: 'Removed',
				dashicon: 'dismiss'
			};

			nfRadio.channel( 'changes' ).request( 'register:change', 'removeField', newModel, null, label );
			
			var changeCollection = nfRadio.channel( 'changes' ).request( 'get:changeCollection' );
			var results = changeCollection.where( { model: fieldModel } );

			_.each( results, function( changeModel ) {
				if ( 'object' == typeof changeModel.get( 'data' ) ) {
					_.each( changeModel.get( 'data' ), function( dataModel ) {
						if ( dataModel.model == fieldModel ) {
							dataModel.model = newModel;
						}
					} );
				}
				changeModel.set( 'model', newModel );
				changeModel.set( 'disabled', true );
			} );

			nfRadio.channel( 'fields' ).request( 'delete:field', fieldModel );
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
			var newModel = nfRadio.channel( 'app' ).request( 'clone:modelDeep', model );

			// Change our label.
			newModel.set( 'label', newModel.get( 'label' ) + ' Copy' );
			// Update our ID to the new tmp id.
			var tmpID = nfRadio.channel( 'fields' ).request( 'get:tmpFieldID' );
			newModel.set( 'id', tmpID );
			// Add new model.
			nfRadio.channel( 'fields' ).request( 'add:field', newModel );
			// Add our field addition to our change log.
			var label = {
				object: 'Field',
				label: model.get( 'label' ),
				change: 'Duplicated',
				dashicon: 'admin-page'
			};

			var data = {
				collection: nfRadio.channel( 'fields' ).request( 'get:fieldCollection' )
			}

			nfRadio.channel( 'changes' ).request( 'register:change', 'duplicateObject', newModel, null, label, data );
			
			// Update preview.
			nfRadio.channel( 'app' ).request( 'update:db' );
		}

	});

	return controller;
} );