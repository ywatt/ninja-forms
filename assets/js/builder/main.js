require.config( {
	baseUrl: nfAdmin.requireBaseUrl
} );

var nfRadio = Backbone.Radio;

jQuery( document ).ready( function( $ ) {
	require( ['builder/views/builder', 'builder/controllers/loadControllers'], function( BuilderView, LoadControllers ) {

		var NinjaForms = Marionette.Application.extend( {

			initialize: function( options ) {		
				var loadControllers = new LoadControllers();
			},

			onStart: function() {
				var builderView = new BuilderView();

				// Setup our default domain
				var appDomains = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
				var defaultDomain = appDomains.get( 'fields' );
				nfRadio.channel( 'app' ).trigger( 'click:appMenu', defaultDomain );
				
			}
		} );
	
		var ninjaForms = new NinjaForms();
		ninjaForms.start();		
	} );
} );