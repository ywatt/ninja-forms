define( ['builder/models/fieldTypeSectionModel'], function( fieldTypeSectionModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldTypeSectionModel
	} );
	return collection;
} );