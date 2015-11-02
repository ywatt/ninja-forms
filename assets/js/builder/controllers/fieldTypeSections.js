define( ['builder/models/fieldTypeSectionCollection'], function( fieldTypeSectionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.fieldTypeSections = new fieldTypeSectionCollection( [
				{ 
					id: 'common',
					nicename: 'Common Fields',
					fieldTypes: [
						'textbox',
						'listradio',
						'dropdown',
						'textarea',
						'submit'
					]
				},
				{ 
					id: 'userinfo',
					nicename: 'User Information Fields',
					fieldTypes: [
						'firstname',
						'lastname',
						'email',
						'city',
						'state',
						'zip'
					]
				},
				// { 
				// 	id: 'advanced',
				// 	nicename: 'Advanced Fields',
				// 	fieldTypes: [
				// 		'calc',
				// 		'test'
				// 	]
				// }
			] );

            nfRadio.channel( 'drawer' ).reply( 'get:fieldTypeSections', this.getFieldTypeSections, this );
		},

        getFieldTypeSections: function() {
            return this.fieldTypeSections;
        }
	});

	return controller;
} );