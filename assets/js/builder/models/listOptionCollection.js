define( ['builder/models/listOptionModel'], function( listOptionModel ) {
	var collection = Backbone.Collection.extend( {
		model: listOptionModel,
		comparator: 'order'
	} );
	return collection;
} );