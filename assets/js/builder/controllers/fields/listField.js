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
define( ['builder/models/fields/listOptionCollection', 'builder/views/drawerFieldTypeSettingListComposite'], function( listOptionCollection, listCompositeView ) {
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
			if ( ! model.get( 'options' ) ) {
				model.set( 'options', [ { calc: 1, label: 'One', value: 'one' }, { calc: 2, label: 'Two', value: 'two' }, { calc: 3, label: 'Three', value: 'three' } ] );
			}
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
		updateOptionSortable: function( sortable, setting ) {
			var newOrder = jQuery( sortable ).sortable( 'toArray' );
			_.each( newOrder, function( cid, index ) {
				setting.collection.get( { cid: cid } ).set( 'order', index );
			} );
			setting.collection.sort();

			this.triggerFieldModel( setting.collection, setting.fieldModel );
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