define( ['builder/models/drawerModel'], function( drawerModel ) {
	var collection = Backbone.Collection.extend( {
		model: drawerModel
	} );
	return collection;
} );