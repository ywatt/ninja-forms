require.config( {
	baseUrl: nfFrontEnd.requireBaseUrl
} );

require( ['lib/backbone.radio', 'front-end/models/formModel', 'front-end/models/fieldCollection', 'front-end/controllers/loadControllers', 'front-end/views/mainLayout'], function( Radio, formModel, FieldCollection, LoadControllers, mainLayout ) {

	var NinjaForms = Marionette.Application.extend({
		forms: {},
		initialize: function( options ) {		
			Radio.channel( 'fields' ).reply( 'get:field', this.getField, this );

			var loadControllers = new LoadControllers();
			/*
			 * Setup our field collections.
			 */
			var that = this;

			_.each( nfForms, function( form, index ) {
				that.forms[index] = new formModel( form[0] );
				var fields = new FieldCollection( form[0].fields );
				that.forms[index].set( 'fields', fields );
			} );

			_.each( this.forms, function( form ) {
				_.each( form.get( 'fields' ).models, function( field ) {
					Radio.channel( 'fields' ).trigger( 'init:model', field );
				} );
			} );
			
		},
		onStart: function() {
			_.each( this.forms, function( form ) {
				var layoutView = new mainLayout( { model: form, fieldCollection: form.get( 'fields' ) } );				
			} );
		},
		getField: function( id ) {
			var model = false;
			_.each( this.forms, function( form ) {
				if ( ! model ) {
					model = form.get( 'fields' ).get( id );	
				}			
			} );
			return model;
		}
	});

	var ninjaForms = new NinjaForms();
	ninjaForms.start();
} );
