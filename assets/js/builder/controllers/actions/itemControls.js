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
			this.listenTo( nfRadio.channel( 'actions' ), 'click:edit', this.clickEdit );
			this.listenTo( nfRadio.channel( 'actions' ), 'click:delete', this.clickDelete );
			this.listenTo( nfRadio.channel( 'actions' ), 'click:duplicate', this.clickDuplicate );

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
			nfRadio.channel( 'actions' ).request( 'clear:editActive' );
			model.set( 'editActive', true );
			var type = nfRadio.channel( 'actions' ).request( 'get:type' , model.get( 'type' ) );
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
			// Temporary value used to store any new collections.
			var replace = {};
			// Loop over every model attribute and if we find a collection, clone each model and instantiate a new collection.
			_.each( model.attributes, function( val, key ) {
				if( val instanceof Backbone.Collection ) { // Is this a backbone collection?
					// Clone each model.
					var models = val.map( function( model ) { return model.clone(); } );
					var options = _.clone( val.options );
					var copy = new val.constructor( models, options );
					replace[ key ] = copy;
				}
			} );

			// Clone our original model
			var newModel = model.clone();
			// Overwrite any collections we created above.
			_.each( replace, function( val, key ) {
				newModel.set( key, val );
			} );

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

			nfRadio.channel( 'changes' ).request( 'register:change', 'duplicateField', newModel, null, label );
			
			// Update preview.
			nfRadio.channel( 'app' ).request( 'update:db' );
		}

	});

	return controller;
} );