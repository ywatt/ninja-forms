define( ['front-end/models/fieldModel'], function( fieldModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldModel
	} );
	return collection;
} );