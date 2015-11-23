/**
 * Handles list field stuff.
 * 
 * When we instantiate a new field with the list type as a parent, we need to instantiate a new listOptionCollection for the 'options' attribute
 *
 * Also listens for changes to the options settings.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/fields/listOptionModel', 'builder/models/fields/listOptionCollection', 'builder/views/fields/drawer/typeSettingListComposite'], function( listOptionModel, listOptionCollection, listCompositeView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Respond to requests for the childView for list type fields.
			nfRadio.channel( 'list-repeater' ).reply( 'get:settingChildView', this.getSettingChildView, this );
						
			// When a list type field is initialized, create an option collection.
			this.listenTo( nfRadio.channel( 'fields-list' ), 'init:fieldModel', this.createOptionCollection );
			
			// Listen for changes to our list options.
			this.listenTo( nfRadio.channel( 'list-repeater' ), 'change:option', this.changeOption );
			this.listenTo( nfRadio.channel( 'list-repeater' ), 'click:addOption', this.addOption );
			this.listenTo( nfRadio.channel( 'list-repeater' ), 'click:deleteOption', this.deleteOption );

			// Respond to requests related to our list options sortable.
			nfRadio.channel( 'list-repeater' ).reply( 'update:optionSortable', this.updateOptionSortable, this );
			nfRadio.channel( 'list-repeater' ).reply( 'stop:optionSortable', this.stopOptionSortable, this );
			nfRadio.channel( 'list-repeater' ).reply( 'start:optionSortable', this.startOptionSortable, this );
		},

		/**
		 * Instantiate an option collection when a list field type is initialized.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	field model being initialized
		 * @return void
		 */
		createOptionCollection: function( model ) {
			var options = model.get( 'options' );
			if ( ! options ) {
				model.set( 'options', [ { calc: 1, label: 'One', value: 'one', order: 0, selected: 0 }, { calc: 2, label: 'Two', value: 'two', order: 1, selected: 0 }, { calc: 3, label: 'Three', value: 'three', order: 2, selected: 0 } ], { silent: true } );
			}

			if ( false == options instanceof Backbone.Collection ) {
				var optionCollection = new listOptionCollection();
				optionCollection.add( model.get( 'options' ) );
				model.set( 'options', optionCollection, { silent: true } );
			}
		},

		/**
		 * Update an option value in our model.
		 * 
		 * @since  3.0
		 * @param  Object			e          event
		 * @param  backbone.model 	model      option model
		 * @param  backbone.model 	fieldModel field model
		 * @return void
		 */
		changeOption: function( e, model, fieldModel ) {
			var name = jQuery( e.target ).data( 'id' );
			if ( 'selected' == name ) {
				if ( jQuery( e.target ).attr( 'checked' ) ) {
					var value = 1;
				} else {
					var value = 0;
				}
			} else {
				var value = jQuery( e.target ).val();
			}
			
			var before = model.get( name );

			model.set( name, value );
			// Triger an update on our fieldModel
			this.triggerFieldModel( model, fieldModel );

			var after = value;
			
			var changes = {
				attr: name,
				before: before,
				after: after
			}

			var label = {
				object: 'Field',
				label: fieldModel.get( 'label' ),
				change: 'Option ' + model.get( 'label' ) + ' ' + name + ' changed from ' + before + ' to ' + after
			};

			nfRadio.channel( 'changes' ).request( 'register:change', 'changeSetting', model, changes, label );
		},

		/**
		 * Add an option to our list
		 * 
		 * @since 3.0
		 * @param backbone.collection 	collection 	list option collection
		 * @param backbone.model 		fieldModel 	field model
		 * @return void
		 */
		addOption: function( collection, fieldModel ) {
			var model = new listOptionModel( { label: '', value: '', calc: '', selected: 0, order: collection.length } );
			collection.add( model );

			// Add our field addition to our change log.
			var label = {
				object: 'Field',
				label: fieldModel.get( 'label' ),
				change: 'Option Added',
				dashicon: 'plus-alt'
			};

			nfRadio.channel( 'changes' ).request( 'register:change', 'addListOption', model, null, label );
			
			this.triggerFieldModel( model, fieldModel );
		},

		/**
		 * Delete an option from our list
		 * 
		 * @since  3.0
		 * @param backbone.model 		model       list option model
		 * @param backbone.collection 	collection 	list option collection
		 * @param backbone.model 		fieldModel 	field model
		 * @return void
		 */
		deleteOption: function( model, collection, fieldModel ) {
			var newModel = nfRadio.channel( 'app' ).request( 'clone:modelDeep', model );

			// Add our field deletion to our change log.
			var label = {
				object: 'Field',
				label: fieldModel.get( 'label' ),
				change: 'Option ' + newModel.get( 'label' ) + ' Removed',
				dashicon: 'dismiss'
			};

			var data = {
				collection: collection
			}

			nfRadio.channel( 'changes' ).request( 'register:change', 'removeListOption', newModel, null, label, data );
			
			var changeCollection = nfRadio.channel( 'changes' ).request( 'get:changeCollection' );
			var results = changeCollection.where( { model: model } );

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

			collection.remove( model );
			this.triggerFieldModel( model, fieldModel );
		},

		/**
		 * Creates an arbitrary value on our collection, then clones and updates that collection.
		 * This forces a change event to be fired on the fieldModel where the list option collection data is stored.
		 * 
		 * @since  3.0
		 * @param backbone.collection 	collection 	list option collection
		 * @param backbone.model 		fieldModel 	field model
		 * @return void
		 */
		triggerFieldModel: function( model, fieldModel ) {
			nfRadio.channel( 'app' ).trigger( 'update:setting', model );	
		},

		/**
		 * Return our list composite view to the setting collection view.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	settings model
		 * @return void
		 */
		getSettingChildView: function( model ) {
			return listCompositeView;
		},

		/**
		 * When we sort our list options, change the order in our option model and trigger a change.
		 * 
		 * @since  3.0
		 * @param  Object	 		sortable 	jQuery UI element
		 * @param  backbone.model 	setting  	Setting model
		 * @return void
		 */
		updateOptionSortable: function( ui, sortable, setting ) {
			var newOrder = jQuery( sortable ).sortable( 'toArray' );
			var dragModel = setting.collection.get( { cid: jQuery( ui.item ).prop( 'id' ) } );
			var data = {
				collection: setting.collection,
				objModels: []
			};
			_.each( newOrder, function( cid, index ) {
				var optionModel = setting.collection.get( { cid: cid } );
				var oldPos = optionModel.get( 'order' );
				optionModel.set( 'order', index );
				var newPos = index;

				data.objModels.push( {
					model: optionModel,
					attr: 'order',
					before: oldPos,
					after: newPos
				} );
			} );
			
			setting.collection.sort();

			var label = {
				object: 'Field',
				label: setting.fieldModel.get( 'label' ),
				change: 'Option ' + dragModel.get( 'label' ) + ' re-ordered from ' + dragModel._previousAttributes.order + ' to ' + dragModel.get( 'order' ),
				dashicon: 'sort'
			};

			nfRadio.channel( 'changes' ).request( 'register:change', 'sortListOptions', dragModel, null, label, data );

			this.triggerFieldModel( dragModel, setting.fieldModel );
		},

		/**
		 * When we stop sorting our list options, reset our item opacity.
		 * 
		 * @since  3.0
		 * @param  Object ui jQuery UI element
		 * @return void
		 */
		stopOptionSortable: function( ui ) {
			jQuery( ui.item ).css( 'opacity', '' );
		},

		/**
		 * When we start sorting our list options, remove containing divs and set our item opacity to 0.5
		 * 
		 * @since  3.0
		 * @param  Objects ui jQuery UI element
		 * @return void
		 */
		startOptionSortable: function( ui ) {
			jQuery( ui.placeholder ).find( 'div' ).remove();
			jQuery( ui.item ).css( 'opacity', '0.5' ).show();
		}

	});

	return controller;
} );