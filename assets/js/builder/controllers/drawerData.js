define( ['builder/models/drawerCollection', 'builder/views/drawerAddField', 'builder/views/drawerEditField', 'builder/views/drawerEditAction', 'builder/views/drawerEditFormSettings'], function( drawerCollection, addFieldView, editFieldView, editActionView, editFormSettingsView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new drawerCollection( [
				{
					id: 'addField',

					getView: function() {
						return new addFieldView();
					}
				},
				{
					id: 'editField',

					getView: function() {
						return new editFieldView();
					}
				},
				{
					id: 'editAction',

					getView: function() {
						return new editActionView();
					}
				},
				{
					id: 'editFormSettings',

					getView: function() {
						return new editFormSettingsView();
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