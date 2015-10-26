define( ['builder/models/fieldTypeCollection'], function( fieldTypeCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new fieldTypeCollection( [
				{ 
					id: 'textbox',
					nicename: 'Textbox',
					alias: [ 'input' ],
					settingGroups: [
						{
							name: '',
							settings: [
								{
									type: 'textbox',
									name: 'label',
									label: 'Label',
									width: 'one-half'
								},
								{
									type: 'textbox',
									name: 'placeholder',
									label: 'Placeholder',
									width: 'one-half'
								},
								{
									type: 'dropdown',
									name: 'label_pos',
									label: 'Label Position',
									options: [
										{
											label: 'Above Field',
											value: 'above'
										},
										{
											label: 'Below Field',
											value: 'below'
										},
										{
											label: 'Left of Field',
											value: 'left'
										},
										{
											label: 'Right of Field',
											value: 'right'
										},
										{
											label: 'Hide Label',
											value: 'hidden'
										}
									],
									width: 'one-half'
								},
								{
									type: 'toggle',
									name: 'required',
									label: 'Required Field',
									width: 'one-half'
								}
							]
						},
						{
							name: 'Restriction Settings',
							settings: [
								{
									type: 'dropdown',
									name: 'mask',
									label: 'Input Mask',
									options: [
										{
											label: 'US Phone',
											value: 'us-phone'
										},
										{
											label: 'Date',
											value: 'date'
										}
									],
									width: 'one-half'
								},
								{
									type: 'open-settings-fieldset',
									label: 'Limit Input to this Number'
								},
								{
									type: 'textbox',
									label: '',
									width: 'one-half'
								},
								{
									type: 'dropdown',
									label: '',
									options: [
										{
											label: 'Character(s)',
											value: 'characters'
										},
										{
											label: 'Word(s)',
											value: 'words'
										}
									],
									width: 'one-half'
								},
								{
									type: 'textbox',
									label: 'Text to Appear After Counter',
									width: 'full'
								},
								{
									type: 'close-settings-fieldset'
								}
							]
						},
						{
							name: 'Advanced Settings',
							settings: [

							]
						},
						{
							name: 'Conditional Settings',
							settings: [

							]
						}
					]
				},
				{
					id: 'radio',
					nicename: 'Radio Buttons',
					alias: ['input', 'list']
				},
				{
					id: 'dropdown',
					nicename: 'Dropdown',
					alias: [ 'select' ]
				},
				{
					id: 'textarea',
					nicename: 'Textarea',
					alias: [ 'message' ]
				},
				{
					id: 'submit',
					nicename: 'Submit',
					alias: ['button']
				},
				{
					id: 'firstname',
					nicename: 'First Name',
					tags: ['contact']
				},
				{
					id: 'lastname',
					nicename: 'Last Name',
					tags: ['contact']
				},
				{
					id: 'email',
					nicename: 'Email',
					alias: ['html5'],
					tags: ['contact']
				},
				{
					id: 'address',
					nicename: 'Address',
					tags: ['contact']
				},
				{
					id: 'city',
					nicename: 'City',
					tags: ['contact']
				},
				{
					id: 'state',
					nicename: 'State',
					tags: ['contact']
				},
				{
					id: 'zip',
					nicename: 'Zip Code',
					tags: ['contact']
				},
				{
					id: 'phone',
					nicename: 'Phone',
					alias: ['telephone'],
					tags: ['contact']
				},
				{
					id: 'calc',
					nicename: 'Display Calculation'
				},
				{
					id: 'test',
					nicename: 'Something Crazy'
				},
				{
					id: 'patient-id',
					nicename: 'Patient ID',
					savedField: true
				},
				{
					id: 'doctors-name',
					nicename: 'Doctor\'s Name',
					savedField: true
				},
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