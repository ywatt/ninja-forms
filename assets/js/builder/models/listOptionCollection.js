define( ['builder/models/listOptionModel'], function( listOptionModel ) {
	var collection = Backbone.Collection.extend( {
		model: listOptionModel,
		comparator: 'order',

		initialize: function() {
			this.on( 'sort', this.changeCollection, this );
		},

		changeCollection: function() {
			nfRadio.channel( 'field-list' ).trigger( 'sort:options', this );
		}
	} );
	return collection;
} );