define( ['builder/models/fieldTypeSettingGroupModel'], function( fieldTypeSettingGroupModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldTypeSettingGroupModel
	} );
	return collection;
} );