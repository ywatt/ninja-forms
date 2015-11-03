define( ['builder/models/fieldModel'], function( fieldModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldModel,
		comparator: 'order',

		initialize: function() {
			this.on( 'change:order', this.changeCollection, this );
		},

		changeCollection: function() {
			this.sort();
		}
	} );
	return collection;
} );