define( [
	'builder/models/drawerCollection',
	'builder/views/drawerAddField',
	'builder/views/drawerEditField',
	'builder/views/drawerAddAction',
	'builder/views/drawerEditAction',
	'builder/views/drawerEditFormSettings'
	], function(
		drawerCollection,
		addFieldView,
		editFieldView,
		addActionView,
		editActionView,
		editFormSettingsView
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new drawerCollection( [
				{
					id: 'addField',

					getView: function( data ) {
						return new addFieldView( data );
					}
				},
				{
					id: 'editField',

					getView: function( data ) {
						return new editFieldView( data );
					}
				},
				{
					id: 'editAction',

					getView: function( data ) {
						return new editActionView( data );
					}
				},
				{
					id: 'addAction',

					getView: function( data ) {
						return new addActionView( data );
					}
				},
				{
					id: 'editFormSettings',

					getView: function( data ) {
						return new editFormSettingsView( data );
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