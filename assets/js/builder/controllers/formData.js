define( ['builder/models/formModel'], function( formModel) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.model = new formModel;
			this.model.set( 'id', preloadedFormData.id );
			this.model.set( 'fields', nfRadio.channel( 'data' ).request( 'get:fieldCollection' ) );
			this.model.set( 'settings', preloadedFormData.settings );

			nfRadio.channel( 'data' ).reply( 'get:formData', this.getFormData, this );
		},

		getFormData: function() {
			return this.model;
		}

	});

	return controller;
} );