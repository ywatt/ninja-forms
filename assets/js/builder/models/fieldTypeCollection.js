define( ['builder/models/fieldTypeModel'], function( fieldTypeModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldTypeModel
	} );
	return collection;
} );