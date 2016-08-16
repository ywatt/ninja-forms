define( ['models/fieldModel'], function( fieldModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldModel,
		comparator: 'order',

		initialize: function( models, options ) {
			this.options = options;
		},

		validateFields: function() {
			_.each( this.models, function( fieldModel ) {
				nfRadio.channel( 'submit' ).trigger( 'validate:field', fieldModel );
			}, this );
		}
	} );
	return collection;
} );