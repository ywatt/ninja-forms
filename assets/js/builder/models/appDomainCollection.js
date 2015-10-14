define( ['builder/models/appDomainModel'], function( appDomainModel ) {
	var collection = Backbone.Collection.extend( {
		model: appDomainModel
	} );
	return collection;
} );