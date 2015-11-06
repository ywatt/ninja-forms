/**
 * Config file for our app drawers.
 *
 * this.collection represents all of our registered drawers.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [
	'builder/models/drawerCollection',
	'builder/views/drawerAddField',
	'builder/views/drawerEditField',
	'builder/views/drawerAddAction',
	'builder/views/drawerEditAction',
	'builder/views/drawerEditFormSettings',
	'builder/views/drawerContentViewChanges',
	'builder/views/drawerHeaderViewChanges'
	], function(
		drawerCollection,
		addFieldView,
		editFieldView,
		addActionView,
		editActionView,
		editFormSettingsView,
		viewChangesView,
		viewChangesHeaderView
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new drawerCollection( [
				{
					id: 'addField',

					getContentView: function( data ) {
						return new addFieldView( data );
					}
				},
				{
					id: 'editField',

					getContentView: function( data ) {
						return new editFieldView( data );
					}
				},
				{
					id: 'editAction',

					getContentView: function( data ) {
						return new editActionView( data );
					}
				},
				{
					id: 'addAction',

					getContentView: function( data ) {
						return new addActionView( data );
					}
				},
				{
					id: 'editFormSettings',

					getContentView: function( data ) {
						return new editFormSettingsView( data );
					}
				},
				{
					id: 'viewChanges',

					// getHeaderView() is defined by default, but we need to override it for the viewChanges drawer.
					getHeaderView: function( data ) {
						return new viewChangesHeaderView( data );
					},

					getContentView: function( data ) {
						return new viewChangesView( data );
					}
				}
			] );

			// Listen for requests for our drawer collection.
			nfRadio.channel( 'app' ).reply( 'get:drawerCollection', this.getDrawerCollection, this );
			// Listen for requests for specific drawer models.
			nfRadio.channel( 'app' ).reply( 'get:drawer', this.getDrawer, this );
		},

		getDrawerCollection: function() {
			return this.collection;
		},

		getDrawer: function( id ) {
			return this.collection.get( id );
		}

	});

	return controller;
} );