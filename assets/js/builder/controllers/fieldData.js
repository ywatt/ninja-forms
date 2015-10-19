define( ['builder/models/fieldCollection'], function( fieldCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new fieldCollection( [
				
				{
					id: 1,
					type: 'first_name',
					label: 'First Name',
					label_pos: 'above',
					default_value: '',
					placeholder: ''
				},
				{
					id: 2,
					type: 'last_name',
					label: 'Last Name',
					label_pos: 'above',
					default_value: '',
					placeholder: ''
				},
				{
					id: 3,
					type: 'textarea',
					label: 'Message',
					label_pos: 'above',
					default_value: '',
					placeholder: ''
				},
				{
					id: 4,
					type: 'submit',
					label: 'Submit',
					default_value: '',
					placeholder: ''
				}
				
			] );

			nfRadio.channel( 'data' ).reply( 'get:fieldCollection', this.getFieldCollection, this );
			nfRadio.channel( 'data' ).reply( 'add:fieldData', this.addFieldData, this );
		},

		getFieldCollection: function() {
			return this.collection;
		},

		addFieldData: function( data ) {
			this.collection.add( data );
		}
	});

	return controller;
} );