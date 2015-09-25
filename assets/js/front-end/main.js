require.config( {
	baseUrl: nfFrontEnd.requireBaseUrl
} );

jQuery( document ).ready( function( $ ) {
	require( ['lib/backbone.radio', 'front-end/models/formCollection', 'front-end/models/formModel', 'front-end/models/fieldCollection', 'front-end/controllers/loadControllers', 'front-end/views/mainLayout'], function( Radio, formCollection, FormModel, FieldCollection, LoadControllers, mainLayout ) {

		var NinjaForms = Marionette.Application.extend({
			forms: {},
			initialize: function( options ) {		
				Radio.channel( 'fields' ).reply( 'get:field', this.getField, this );
				Radio.channel( 'form' ).reply( 'get:form', this.getForm, this );
				var loadControllers = new LoadControllers();
				/*
				 * Setup our field collections.
				 */
				var that = this;

				/*
				 * Initialize our form collection (incase we have multiple forms on the page)
				 */
				this.forms = new formCollection();

				_.each( nfForms, function( form, index ) {
					var formModel = new FormModel( form[0] );
					var fields = new FieldCollection( form[0].fields );
					formModel.set( 'fields', fields );
					that.forms.add( formModel );
				} );

				_.each( this.forms.models, function( form ) {
					_.each( form.get( 'fields' ).models, function( field ) {
						field.set( 'formID', form.get( 'id' ) );
						Radio.channel( field.get( 'type' ) ).trigger( 'init:model', field );
						Radio.channel( 'fields' ).trigger( 'init:model', field );
					} );
				} );
				
			},
			onStart: function() {
				_.each( this.forms.models, function( form, index ) {
					var layoutView = new mainLayout( { model: form, fieldCollection: form.get( 'fields' ) } );			
				} );
			},
			getField: function( id ) {
				var model = false;
				_.each( this.forms.models, function( form ) {
					if ( ! model ) {
						model = form.get( 'fields' ).get( id );	
					}			
				} );
				return model;
			},
			getForm: function( id ) {
				return this.forms.get( id );
			}
		});
	
		var ninjaForms = new NinjaForms();
		ninjaForms.start();		
	} );
} );