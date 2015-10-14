define( ['builder/models/appMenuItemModel'], function( appMenuItemModel ) {
	var collection = Backbone.Collection.extend( {
		model: appMenuItemModel
	} );
	return collection;
} );