define( ['builder/models/fieldTypeSectionCollection'], function( fieldTypeSectionCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.collection = new fieldTypeSectionCollection( [
				{ 
					id: 'saved',
					nicename: 'Saved Fields',
					classes: 'nf-favorites',
					fieldTypes: [
						'firstname',
						'lastname',
						'email',
						'address',
						'submit',
						'firstname',
						'lastname',
						'email',
						'address',
						'submit',
						'firstname',
						'lastname',
						'email',
						'address',
						'submit',
						'firstname',
						'lastname',
						'email',
						'address',
						'submit',
						'firstname',
						'lastname',
						'email',
						'address',
						'submit'	
					]
				}
			] );

            nfRadio.channel( 'drawer' ).reply( 'get:savedFields', this.getSavedFields, this );
		},

        getSavedFields: function() {
            return this.collection;
        }
	});

	return controller;
} );