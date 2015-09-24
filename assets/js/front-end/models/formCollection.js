define( ['front-end/models/formModel'], function( formModel ) {
	var collection = Backbone.Collection.extend( {
		model: formModel
	} );
	return collection;
} );