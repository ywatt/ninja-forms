define( ['builder/models/stagingCollection'], function( stagingCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new stagingCollection();

		    nfRadio.channel( 'data' ).reply( 'get:stagedFields', this.getStagingCollection, this );
			nfRadio.channel( 'data' ).reply( 'add:stagedField', this.addStagedField, this );
			nfRadio.channel( 'data' ).reply( 'remove:stagedField', this.removeStagedField, this );
			nfRadio.channel( 'data' ).reply( 'sort:stagedFields', this.sortStagedFields, this );
			nfRadio.channel( 'data' ).reply( 'clear:stagedFields', this.clearStagedFields, this );
			
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:removeStagedField', this.removeStagedField );
			this.listenTo( nfRadio.channel( 'drawer' ), 'before:closeDrawer', this.beforeCloseDrawer );
		},

		getStagingCollection: function() {
			return this.collection;
		},

		addStagedField: function( type ) {
			var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', type );
			var tmpID = 'nf-staged-field-' + jQuery.now();
			var data = {
				id: tmpID,
				slug: fieldType.get( 'id' ),
				nicename: fieldType.get( 'nicename' )
			}
			this.collection.add( data );
			return tmpID;
		},

		removeStagedField: function( el, model ) {
			this.collection.remove( model );
		},

		beforeCloseDrawer: function() {
			var fieldCollection = nfRadio.channel( 'data' ).request( 'get:fieldCollection' );
			var tmpNum = fieldCollection.models.length + 1;
			var fields = [];
			_.each( this.collection.models, function( model ) {
				fields.push( { id: 'tmp-' + tmpNum, label: model.get( 'nicename' ), type: model.get( 'slug' ) } );
				tmpNum++;
			} );
			nfRadio.channel( 'data' ).request( 'add:fieldData', fields );
			this.collection.reset();
		},

		sortStagedFields: function() {
			var sortableEl = nfRadio.channel( 'app' ).request( 'get:stagedFieldsEl' );
			var order = jQuery( sortableEl ).sortable( 'toArray' );

			_.each( this.collection.models, function( field ) {
				var search = field.get( 'id' );
				var pos = order.indexOf( search );
				field.set( 'order', pos );
			} );
			this.collection.sort();
		},

		clearStagedFields: function() {
			this.collection.reset();
		}

	});

	return controller;
} );