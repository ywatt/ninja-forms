define( ['builder/models/fieldTypeCollection'], function( fieldTypeCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new fieldTypeCollection( [
				{ id: 'textbox', nicename: 'Textbox', alias: [ 'input' ] },
				{ id: 'radio', nicename: 'Radio Buttons', alias: ['input', 'list']  },
				{ id: 'dropdown', nicename: 'Dropdown', alias: [ 'select' ] },
				{ id: 'textarea', nicename: 'Textarea' },
				{ id: 'submit', nicename: 'Submit', alias: ['button'] },
				{ id: 'firstname', nicename: 'First Name', tags: ['contact'] },
				{ id: 'lastname', nicename: 'Last Name', tags: ['contact'] },
				{ id: 'email', nicename: 'Email', alias: ['html5'], tags: ['contact'] },
				{ id: 'address', nicename: 'Address', tags: ['contact'] },
				{ id: 'zip', nicename: 'Zip Code', tags: ['contact'] },
				{ id: 'phone', nicename: 'Phone', alias: ['telephone'], tags: ['contact'] },
				{ id: 'calc', nicename: 'Display Calculation' },
				{ id: 'test', nicename: 'Something Crazy' },
				{ id: 'patient-id', nicename: 'Patient ID', savedField: true },
				{ id: 'doctors-name', nicename: 'Doctor\'s Name', savedField: true },
			] );

			nfRadio.channel( 'data' ).reply( 'get:fieldType', this.getFieldType, this );
			nfRadio.channel( 'data' ).reply( 'get:fieldTypes', this.getFieldTypes, this );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:fieldType', this.addStagedField );
		},

		getFieldType: function( id ) {
        	return this.collection.get( id );
        },

		getFieldTypes: function( id ) {
        	return this.collection;
        },

        addStagedField: function( el ) {
        	var type = jQuery( el.target ).data( 'id' );
        	nfRadio.channel( 'data' ).request( 'add:stagedField', type );
        }
	});

	return controller;
} );