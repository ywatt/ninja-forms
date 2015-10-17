define( ['builder/models/stagingCollection'], function( stagingCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new stagingCollection();

		    nfRadio.channel( 'drawer' ).reply( 'get:stagedFields', this.getStagingCollection, this );
			nfRadio.channel( 'drawer' ).reply( 'add:stagedField', this.addStagedField, this );
			nfRadio.channel( 'drawer' ).reply( 'remove:stagedField', this.removeStagedField, this );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:removeStagedField', this.removeStagedField );
			this.listenTo( nfRadio.channel( 'drawer' ), 'dropped:fieldStaging', this.addStagedField );
			this.listenTo( nfRadio.channel( 'drawer' ), 'sorted:fieldStaging', this.updateStagedOrder );
			this.listenTo( nfRadio.channel( 'drawer' ), 'before:closeDrawer', this.beforeCloseDrawer );
		},

		getStagingCollection: function() {
			return this.collection;
		},

		addStagedField: function( id ) {
			var type = nfRadio.channel( 'data' ).request( 'get:fieldType', id );
			var data = {
				slug: type.get( 'id' ),
				nicename: type.get( 'nicename' )
			}
			this.collection.add( data );
		},

		removeStagedField: function( el, model ) {
			this.collection.remove( model );
		},

		updateStagedOrder: function( order ) {
			var that = this;
			_.each( order, function( slug, index ) {
				var model = that.collection.where( { slug: slug } );
				model[0].set( 'order', index );
			} );
			this.collection.sort();
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
		}

	});

	return controller;
} );