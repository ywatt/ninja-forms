define( ['builder/models/fieldModel'], function( fieldModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldModel,
		comparator: 'order',

		initialize: function() {
			this.on( 'change:order', this.changeCollection, this );
			this.on( 'add', this.addField, this );
			this.on( 'remove', this.removeField, this );
			this.newIDs = [];
		},

		changeCollection: function() {
			this.sort();
		},

		addField: function( model ) {
			this.newIDs.push( model.get( 'id' ) );
		},

		removeField: function( model ) {
			this.removedIDs[ model.get( 'id' ) ] = model.get( 'id' );
		}
	} );
	return collection;
} );