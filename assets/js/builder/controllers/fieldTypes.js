define( [
	'builder/models/fieldTypeCollection',
	'builder/models/fieldTypeSettingCollection',
	'builder/models/fieldTypeSettingGroupCollection'
	], function(
	fieldTypeCollection,
	fieldTypeSettingCollection,
	fieldTypeSettingGroupCollection
	) {
	var controller = Marionette.Object.extend( {
		initialize: function() {

			this.collection = new fieldTypeCollection( [
				{ 
					id: 'textbox',
					nicename: 'Textbox',
					alias: [ 'input' ],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						},
						{
							name: 'Restriction Settings',
							settings: new fieldTypeSettingCollection( [
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
									type: 'fieldset',
									label: 'Limit Input to this Number',
									width: 'full',
									settings: new fieldTypeSettingCollection( [
										{
											type: 'textbox',
											name: 'input_limit',
											placeholder: '150',
											width: 'one-half'
										},
										{
											type: 'dropdown',
											name: 'input_limit_type',
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
											name: 'input_limit_msg',
											label: 'Text to Appear After Counter',
											placeholder: 'Character(s) left',
											width: 'full'
										}
									] )
								},
								
							] )
						}						
					] )
				},
				{
					id: 'radio',
					nicename: 'Radio Buttons',
					alias: ['input', 'list'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
								{
									type: 'textbox',
									name: 'label',
									label: 'Label',
									width: 'full'
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
							] )
						}					
					] )
				},
				{
					id: 'dropdown',
					nicename: 'Dropdown',
					alias: [ 'select' ],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}						
					] )
				},
				{
					id: 'textarea',
					nicename: 'Textarea',
					alias: [ 'message' ],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
								{
									type: 'textbox',
									name: 'label',
									label: 'Label',
									width: 'full'
								},
								{
									type: 'textarea',
									name: 'placeholder',
									label: 'Placeholder',
									width: 'full'
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
							] )
						},
						{
							name: 'Restriction Settings',
							settings: new fieldTypeSettingCollection( [
								{
									type: 'fieldset',
									label: 'Limit Input to this Number',
									width: 'full',
									settings: new fieldTypeSettingCollection( [
										{
											type: 'textbox',
											name: 'input_limit',
											placeholder: '150',
											width: 'one-half'
										},
										{
											type: 'dropdown',
											name: 'input_limit_type',
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
											name: 'input_limit_msg',
											label: 'Text to Appear After Counter',
											placeholder: 'Character(s) left',
											width: 'full'
										}
									] )
								},
								
							] )
						}						
					] )
				},
				{
					id: 'submit',
					nicename: 'Submit',
					alias: ['button'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
								{
									type: 'textbox',
									name: 'label',
									label: 'Label',
									width: 'full'
								}								
							] )
						}
					] )
				},
				{
					id: 'firstname',
					nicename: 'First Name',
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}						
					] )
				},
				{
					id: 'lastname',
					nicename: 'Last Name',
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'email',
					nicename: 'Email',
					alias: ['html5'],
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'address',
					nicename: 'Address',
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'city',
					nicename: 'City',
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'state',
					nicename: 'State',
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'zip',
					nicename: 'Zip Code',
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'phone',
					nicename: 'Phone',
					alias: ['telephone'],
					tags: ['contact'],
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'calc',
					nicename: 'Display Calculation',
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'patient-id',
					nicename: 'Patient ID',
					savedField: true,
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				},
				{
					id: 'doctors-name',
					nicename: 'Doctor\'s Name',
					savedField: true,
					settingGroups: new fieldTypeSettingGroupCollection( [
						{
							name: '',
							display: true,
							settings: new fieldTypeSettingCollection( [
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
							] )
						}
					] )
				}
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