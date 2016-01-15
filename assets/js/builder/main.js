require.config( {
	baseUrl: nfAdmin.requireBaseUrl + '/builder/'
} );

var nfRadio = Backbone.Radio;

jQuery.fn.nextElementInDom = function(selector, options) {
	var defaults = { stopAt : 'body' };
	options = jQuery.extend(defaults, options);

	var parent = jQuery(this).parent();
	var found = parent.find(selector);

	switch(true){
		case (found.length > 0):
			return found;
		case (parent.length === 0 || parent.is(options.stopAt)):
			return jQuery([]);
		default:
			return parent.nextElementInDom(selector);
	}
};

jQuery( document ).ready( function( $ ) {
	require( ['views/app/builder', 'controllers/loadControllers'], function( BuilderView, LoadControllers ) {

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
				// Trigger our after start event.
				nfRadio.channel( 'app' ).trigger( 'after:appStart', this );
			}
		} );
	
		var ninjaForms = new NinjaForms();
		ninjaForms.start();
	} );
} );