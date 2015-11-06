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
define( ['builder/models/listOptionCollection'], function( listOptionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// When a list type field is initialized, create an option collection.
			this.listenTo( nfRadio.channel( 'fields-list' ), 'init:fieldModel', this.createOptionCollection );
			// Listen for changes to our list options.
			this.listenTo( nfRadio.channel( 'list-repeater' ), 'change:option', this.changeOption );
			this.listenTo( nfRadio.channel( 'list-repeater' ), 'click:addOption', this.addOption );
			this.listenTo( nfRadio.channel( 'list-repeater' ), 'click:deleteOption', this.deleteOption );

			// Respond to requests to trigger a change event on our option.
			nfRadio.channel( 'list-repeater' ).reply( 'trigger:change', this.triggerFieldModel, this );
		},

		/**
		 * Instantiate an option collection when a list field type is initialized.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	field model being initialized
		 * @return void
		 */
		createOptionCollection: function( model ) {
			model.set( 'options', new listOptionCollection( model.get( 'options' ) ) );
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
			var value = jQuery( e.target ).val();
			model.set( name, value );
			// Triger an update on our fieldModel
			this.triggerFieldModel( model.collection, fieldModel );
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
			collection.add( { label: '', value: '', calc: '' } );
			this.triggerFieldModel( collection, fieldModel );
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
			collection.remove( model );
			this.triggerFieldModel( collection, fieldModel );
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
		triggerFieldModel: function( collection, fieldModel ) {
			if ( ! collection.arb ) {
				collection.arb = true;
			} else {
				collection.arb = false;
			}
			var optionsClone = _.clone( collection );
			fieldModel.set( 'options', optionsClone );			
		}

	});

	return controller;
} );