define( ['builder/models/fieldCollection', 'builder/models/listOptionCollection'], function( fieldCollection, listOptionCollection ) {
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
					id: 5,
					type: 'radio',
					label: 'Radio Buttons',
					label_pos: 'above',
					default_value: '',
					options: new listOptionCollection( [
						{
							label: 'Item 1',
							value: 'item1',
							calcValue: '1'
						},
						{
							label: 'Item 2',
							value: 'item2',
							calcValue: '2'
						},
						{
							label: 'Item 3',
							value: 'item3',
							calcValue: '3'
						},
						{
							label: 'Item 4',
							value: 'item4',
							calcValue: '4'
						}
					] ),
					order: 3
				},
				{
					id: 3,
					type: 'textarea',
					label: 'Message',
					label_pos: 'above',
					default_value: '',
					placeholder: 'Message',
					order: 4
				},
				{
					id: 4,
					type: 'submit',
					label: 'Submit',
					order: 5
				}
				
			] );

			nfRadio.channel( 'data' ).reply( 'get:fieldCollection', this.getFieldCollection, this );
			nfRadio.channel( 'data' ).reply( 'get:field', this.getField, this );
			nfRadio.channel( 'data' ).reply( 'add:field', this.addField, this );
			nfRadio.channel( 'data' ).reply( 'update:fieldSetting', this.updateFieldSetting, this );
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