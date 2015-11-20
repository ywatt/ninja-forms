/**
 * Creates and stores a collection of action types. This includes all of the settings shown when editing a field.
 *
 * Loops over our preloaded data and adds that to our action type collection
 *
 * Also responds to requests for data about action types
 *
 * @package Ninja Forms builder
 * @subpackage Actions
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [
	'builder/models/app/typeCollection',
	'builder/models/app/settingCollection',
	'builder/models/app/settingGroupCollection',
	], function(
	typeCollection,
	settingCollection,
	settingGroupCollection
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Create our field type collection
			this.collection = new typeCollection();
			
			var that = this;
			_.each( actionTypeData, function( type ) {
				var settingGroups = new settingGroupCollection();
				// Loop through the settings groups within this field type and create an object to add to the groups collection.
				_.each( type.settingGroups, function( group ) {
					var groupTmp = {
						label: group.label,
						display: group.display,
						settings: new settingCollection( group.settings ),
					}
					// Add the tmp object to our setting groups collection
					settingGroups.add( groupTmp );
				} );

				// Build an object for this type that we can add to our field type collection
				var actionType = {
					id: type.id,
					nicename: type.nicename,
					alias: type.alias,
					settingGroups: settingGroups,
					settingDefaults: type.settingDefaults
				}
				// Add tmp object to our field type collection
				that.collection.add( actionType );
			} );

			// Respond to requests to get field type, collection, settings, and sections
			nfRadio.channel( 'actions' ).reply( 'get:type', this.getType, this );
			nfRadio.channel( 'actions' ).reply( 'get:typeCollection', this.getTypeCollection, this );
			nfRadio.channel( 'actions' ).reply( 'get:typeSections', this.getTypeSections, this );
			// Listen to clicks on field types
			// this.listenTo( nfRadio.channel( 'drawer' ), 'click:actionType', this.addStagedField );
		},

		/**
		 * Return a field type by id
		 *
		 * @since  3.0
		 * @param  string 			id 	field type
		 * @return backbone.model    	field type model
		 */
		getType: function( id ) {
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
