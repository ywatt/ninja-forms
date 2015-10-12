define( ['builder/models/stagingModel'], function( stagingModel ) {
	var collection = Backbone.Collection.extend( {
		model: stagingModel,
		comparator: 'order'
	} );
	return collection;
} );