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

					getHeaderView: function( data ) {
						return new viewChangesHeaderView( data );
					},

					getContentView: function( data ) {
						return new viewChangesView( data );
					}
				}
			] );

			nfRadio.channel( 'app' ).reply( 'get:drawerCollection', this.getDrawerCollection, this );
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