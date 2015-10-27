define( ['builder/models/fieldTypeSettingModel'], function( fieldTypeSettingModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldTypeSettingModel
	} );
	return collection;
} );