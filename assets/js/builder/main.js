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
			}
		} );
	
		var ninjaForms = new NinjaForms();
		ninjaForms.start();		
	} );

} );