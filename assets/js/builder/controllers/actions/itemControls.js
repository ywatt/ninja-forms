/**
 * Listens for clicks on our action item action buttons.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - Main Sortable
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Listen for clicks to edit, delete, duplicate actions.
			this.listenTo( nfRadio.channel( 'actions' ), 'click:edit', this.clickEdit );
			this.listenTo( nfRadio.channel( 'actions' ), 'click:delete', this.clickDelete );
			this.listenTo( nfRadio.channel( 'actions' ), 'click:duplicate', this.clickDuplicate );

			// Listen for our drawer close and remove our active edit state
		},

		/**
		 * Open a drawer with our action model for editing settings.
		 * 
		 * @since  3.0
		 * @param  Object			e     	event
		 * @param  backbone.model 	model 	action model
		 * @return void
		 */
		clickEdit: function( e, model ) {
			nfRadio.channel( 'actions' ).request( 'clear:editActive' );
			model.set( 'editActive', true );
			var type = nfRadio.channel( 'actions' ).request( 'get:type' , model.get( 'type' ) );
			nfRadio.channel( 'app' ).request( 'open:drawer', 'editSettings', { model: model, groupCollection: type.get( 'settingGroups' ) } );
		},

		/**
		 * Delete a action model from our collection
		 * 
		 * @since  3.0
		 * @param  Object			e     	event
		 * @param  backbone.model 	model 	action model
		 * @return void
		 */
		clickDelete: function( e, dataModel ) {
			var newModel = nfRadio.channel( 'app' ).request( 'clone:modelDeep', dataModel );

			// Add our action deletion to our change log.
			var label = {
				object: dataModel.get( 'objectType' ),
				label: dataModel.get( 'label' ),
				change: 'Removed',
				dashicon: 'dismiss',
				data: {
					collection: dataModel.collection
				}
			};

			nfRadio.channel( 'changes' ).request( 'register:change', 'removeAction', newModel, null, label );
			
			var changeCollection = nfRadio.channel( 'changes' ).request( 'get:changeCollection' );
			var results = changeCollection.where( { model: dataModel } );

			_.each( results, function( changeModel ) {
				if ( 'object' == typeof changeModel.get( 'data' ) ) {
					_.each( changeModel.get( 'data' ), function( dataModel ) {
						if ( dataModel.model == dataModel ) {
							dataModel.model = newModel;
						}
					} );
				}
				changeModel.set( 'model', newModel );
				changeModel.set( 'disabled', true );
			} );

			nfRadio.channel( 'actions' ).request( 'delete:action', dataModel );
		},

		/**
		 * Duplicate a action within our collection, adding the word "copy" to the label.
		 * 
		 * @since  3.0
		 * @param  Object			e     	event
		 * @param  backbone.model 	model 	action model
		 * @return void
		 */
		clickDuplicate: function( e, model ) {
			console.log( 'dpulicate' );
			var newModel = nfRadio.channel( 'app' ).request( 'clone:modelDeep', model );

			// Change our label.
			newModel.set( 'label', newModel.get( 'label' ) + ' Copy' );
			// Update our ID to the new tmp id.
			var tmpID = nfRadio.channel( 'actions' ).request( 'get:tmpID' );
			newModel.set( 'id', tmpID );
			// Add new model.
			nfRadio.channel( 'actions' ).request( 'add:action', newModel );
			// Add our action addition to our change log.
			var label = {
				object: model.get( 'objectType' ),
				label: model.get( 'label' ),
				change: 'Duplicated',
				dashicon: 'admin-page'
			};

			var data = {
				collection: nfRadio.channel( 'actions' ).request( 'get:actionCollection' )
			}

			nfRadio.channel( 'changes' ).request( 'register:change', 'duplicateObject', newModel, null, label, data );
			
			// Update preview.
			nfRadio.channel( 'app' ).request( 'update:db' );
		}

	});

	return controller;
} );