/**
 * Creates and stores a collection of field types. This includes all of the settings shown when editing a field.
 * 
 * 1) Create our settings sections config
 * 2) Loops over our preloaded data and adds that to our field type collection
 *
 * Also responds to requests for data about field types
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [
	'builder/models/fields/typeCollection',
	'builder/models/fields/typeSettingCollection',
	'builder/models/fields/typeSettingGroupCollection',
	'builder/models/fields/typeSectionCollection'
	], function(
	fieldTypeCollection,
	fieldTypeSettingCollection,
	fieldTypeSettingGroupCollection,
	fieldTypeSectionCollection
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Create our field type collection
			this.collection = new fieldTypeCollection();
			// Config for our settings sections
			this.fieldTypeSections = new fieldTypeSectionCollection( [
				{
					id: 'common',
					nicename: 'Common Fields',
					fieldTypes: []
				},
				{ 
					id: 'userinfo',
					nicename: 'User Information Fields',
					fieldTypes: []
				}
			] );

			// Since we want to access the "this" context later, we assign it to that so it isn't overwritten
			var that = this;

			// Loop through the field type data variable and add it to the field type collection array
			_.each( fieldTypeData, function ( type ) {
				var settingGroups = new fieldTypeSettingGroupCollection();
				// Loop through the settings groups within this field type and create an object to add to the groups collection.
				_.each( type.settingGroups, function( group ) {
					var groupTmp = {
						label: group.label,
						display: group.display,
						settings: new fieldTypeSettingCollection( group.settings ),
					}
				} );

				// Add our field type to the appropriate drawer section.
				if ( 'undefined' != typeof that.fieldTypeSections.get( type.section ) ) {
					that.fieldTypeSections.get( type.section ).get( 'fieldTypes' ).push( type.id );
				}
				
				// Build an object for this type that we can add to our field type collection
				var fieldType = {
					id: type.id,
					nicename: type.nicename,
					alias: type.alias,
					parentType: type.parentType,
					settingGroups: settingGroups
				}
				// Add tmp object to our field type collection
				that.collection.add( fieldType );
			} );
			
			// Respond to requests to get field type, collection, settings, and sections
			nfRadio.channel( 'fields' ).reply( 'get:type', this.getFieldType, this );
			nfRadio.channel( 'fields' ).reply( 'get:typeCollection', this.getTypeCollection, this );
			nfRadio.channel( 'fields' ).reply( 'get:settingModel', this.getSettingModel, this );
			nfRadio.channel( 'fields' ).reply( 'get:typeSections', this.getTypeSections, this );
			// Listen to clicks on field types		
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:fieldType', this.addStagedField );
		},

		/**
		 * Return a field type by id
		 * 
		 * @since  3.0
		 * @param  string 			id 	field type
		 * @return backbone.model    	field type model
		 */
		getFieldType: function( id ) {
        	return this.collection.get( id );
        },

        /**
         * Return the entire field type collection
         * 
         * @since  3.0
         * @param  string 				id 	[description]
         * @return backbone.collection    	field type collection
         */
		getTypeCollection: function( id ) {
        	return this.collection;
        },

        /**
         * Return an individual field setting model.
         * Loops through our settings groups until we find the setting.
         * 
         * @since  3.0
         * @param  string 			type   	field type
         * @param  string 			search 	setting name
         * @return backbone.model        	setting model
         */
        getSettingModel: function( name ) {
        	var setting = false;
        	_.each( this.collection.models, function( type ) {
				_.find( type.get('settingGroups' ).models, function( group ) {
					setting = group.get( 'settings' ).findWhere( { name: name } );
					if ( setting ) {
						return true;
					}
					_.each( group.get( 'settings' ), function( setting ) {
						if( setting instanceof Backbone.Collection ) { // Is this a backbone collection?

						}
					} );
				} );
        	} );

			return setting;
        },

        /**
         * Add a field type to our staging area when the field type button is clicked.
         * 
         * @since 3.0
         * @param Object e event
         * @return void
         */
        addStagedField: function( e ) {
        	var type = jQuery( e.target ).data( 'id' );
        	nfRadio.channel( 'fields' ).request( 'add:stagedField', type );
        },

        /**
         * Return our field type settings sections
         * 
         * @since  3.0
         * @return backbone.collection field type settings sections
         */
        getTypeSections: function() {
            return this.fieldTypeSections;
        }
	});

	return controller;
} );