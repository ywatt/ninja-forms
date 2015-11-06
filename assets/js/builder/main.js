require.config( {
	baseUrl: nfAdmin.requireBaseUrl
} );

var nfRadio = Backbone.Radio;
var nfUndoManager = new Backbone.UndoManager();

jQuery( document ).ready( function( $ ) {
	require( ['builder/views/builder', 'builder/controllers/loadControllers'], function( BuilderView, LoadControllers ) {

		var NinjaForms = Marionette.Application.extend( {

			initialize: function( options ) {
				// Trigger an event before we load our controllers.
				nfRadio.channel( 'app' ).trigger( 'before:loadControllers', this );
				// Load our controllers.
				var loadControllers = new LoadControllers();
				// Trigger an event after we load our controllers.
				nfRadio.channel( 'app' ).trigger( 'after:loadControllers', this );
			},

			onStart: function() {
				var builderView = new BuilderView();

				// Setup our default domain
				var appDomains = nfRadio.channel( 'app' ).request( 'get:domainCollection' );
				var defaultDomain = appDomains.get( 'fields' );
				nfRadio.channel( 'app' ).trigger( 'click:menu', {}, defaultDomain );

				// Trigger our after start event.
				nfRadio.channel( 'app' ).trigger( 'after:appStart', this );
				// nfUndoManager.startTracking();	
			}
		} );
	
		var ninjaForms = new NinjaForms();
		ninjaForms.start();
	} );
} );