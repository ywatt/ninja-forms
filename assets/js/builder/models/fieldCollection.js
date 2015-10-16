define( ['builder/models/fieldModel'], function( fieldModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldModel
	} );
	return collection;
} );