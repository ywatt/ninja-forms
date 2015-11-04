define( ['builder/models/fieldCollection', 'builder/models/listOptionCollection'], function( fieldCollection, listOptionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			
			this.collection = new fieldCollection( preloadedFormData.fields );
			this.collection.removedIDs = {};
			nfUndoManager.register( this.collection );

			nfRadio.channel( 'data' ).reply( 'get:fieldCollection', this.getFieldCollection, this );
			nfRadio.channel( 'data' ).reply( 'get:field', this.getField, this );
			nfRadio.channel( 'data' ).reply( 'add:field', this.addField, this );
			nfRadio.channel( 'data' ).reply( 'delete:field', this.deleteField, this );
			nfRadio.channel( 'data' ).reply( 'sort:fields', this.sortFields, this );
			nfRadio.channel( 'data' ).reply( 'get:tmpFieldID', this.getTmpFieldID, this );
		},

		getFieldCollection: function() {
			return this.collection;
		},

		getField: function( id ) {
			return this.collection.get( id );
		},

		addField: function( data, silent ) {
			silent = silent || false;
			this.collection.add( data, { silent: silent } );
			nfRadio.channel( 'app' ).request( 'update:preview' );
		},

		updateFieldSetting: function( id, name, value ) {
			var fieldModel = this.collection.get( id );
			fieldModel.set( name, value );
		},

		sortFields: function( order ) {
			var sortableEl = nfRadio.channel( 'app' ).request( 'get:fieldsSortableEl' );
			if ( jQuery( sortableEl ).hasClass( 'ui-sortable' ) ) {
				var order = order || jQuery( sortableEl ).sortable( 'toArray' );

				_.each( this.collection.models, function( field ) {
					var id = field.get( 'id' );
					if ( jQuery.isNumeric( id ) ) {
						var search = 'field-' + id;
					} else {
						var search = id;
					}
					var pos = order.indexOf( search ) + 1;
					pos = pos.toString();
					field.set( 'order', pos );
				} );

				nfRadio.channel( 'app' ).request( 'update:preview' );
			}
		},

		deleteField: function( model ) {
			this.collection.removedIDs[ model.get( 'id' ) ] = model.get( 'id' );
			this.collection.remove( model );
			nfRadio.channel( 'app' ).request( 'update:appSetting', 'clean', false );
			nfRadio.channel( 'app' ).request( 'update:preview' );
		},

		getTmpFieldID: function() {
			var tmpNum = this.collection.models.length + 1;
			return 'tmp-' + tmpNum;
		}
	});

	return controller;
} );