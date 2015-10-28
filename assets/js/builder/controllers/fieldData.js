define( ['builder/models/fieldCollection'], function( fieldCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new fieldCollection( [
				
				{
					id: 1,
					type: 'firstname',
					label: 'First Name',
					label_pos: 'above',
					default_value: '',
					placeholder: 'First Name',
					required: 1,
					order: 1
				},
				{
					id: 2,
					type: 'lastname',
					label: 'Last Name',
					label_pos: 'above',
					default_value: '',
					placeholder: 'Last Name',
					order: 2
				},
				{
					id: 3,
					type: 'textarea',
					label: 'Message',
					label_pos: 'above',
					default_value: '',
					placeholder: 'Message',
					order: 3
				},
				{
					id: 4,
					type: 'submit',
					label: 'Submit',
					order: 4
				}
				
			] );

			nfRadio.channel( 'data' ).reply( 'get:fieldCollection', this.getFieldCollection, this );
			nfRadio.channel( 'data' ).reply( 'add:field', this.addField, this );
			nfRadio.channel( 'data' ).reply( 'update:field', this.updateFieldData, this );
			nfRadio.channel( 'data' ).reply( 'delete:field', this.deleteField, this );
			nfRadio.channel( 'data' ).reply( 'sort:fields', this.sortFields, this );
			nfRadio.channel( 'data' ).reply( 'get:tmpFieldID', this.getTmpFieldID, this );
		},

		getFieldCollection: function() {
			return this.collection;
		},

		addField: function( data, silent ) {
			silent = silent || false;
			this.collection.add( data, { silent: silent } );
		},

		updateField: function( ) {

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
					var pos = order.indexOf( search );
					field.set( 'order', pos );
				} );
				this.collection.sort();			
			}
		},

		deleteField: function( model ) {
			this.collection.remove( model );
		},

		getTmpFieldID: function() {
			var tmpNum = this.collection.models.length + 1;
			return 'tmp-' + tmpNum;
		}
	});

	return controller;
} );