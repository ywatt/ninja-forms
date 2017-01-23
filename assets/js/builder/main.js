var nfRadio = Backbone.Radio;

jQuery( document ).ready( function( $ ) {
	require( ['views/app/builder', 'controllers/loadControllers', 'views/loadViews', 'views/app/builderLoading'], function( BuilderView, LoadControllers, LoadViews, BuilderLoadingView ) {

		var NinjaForms = Marionette.Application.extend( {

			initialize: function( options ) {

				var that = this;
				Marionette.Renderer.render = function(template, data){
					var template = that.template( template );
					return template( data );
				};

				// Trigger an event before we load our controllers.
				nfRadio.channel( 'app' ).trigger( 'before:loadControllers', this );
				// Load our controllers.
				var loadControllers = new LoadControllers();
				// Trigger an event after we load our controllers.
				nfRadio.channel( 'app' ).trigger( 'after:loadControllers', this );

				// Trigger an event before we load un-instantiated views
				nfRadio.channel( 'app' ).trigger( 'before:loadViews', this );
				var loadViews = new LoadViews();
				// Trigger an event after we load un-instantiated views.
				nfRadio.channel( 'app' ).trigger( 'after:loadViews', this );

				nfRadio.channel( 'app' ).reply( 'get:template', this.template );
			},

			onStart: function() {
				/*
				 * Render our loading view.
				 */
				new BuilderLoadingView();

				/*
				 * Add a listener to the appModel so that we can re-render our appView when the loadingBlockers attribute changes
				 */
				var appModel = nfRadio.channel( 'app' ).request( 'get:data' );
				this.listenTo( appModel, 'change:loadingBlockers', this.renderAppView );

				// Trigger our after start event.
				nfRadio.channel( 'app' ).trigger( 'after:appStart', this );
			},

			renderAppView: function() {
				var loadingBlockers = nfRadio.channel( 'app' ).request( 'get:loadingBlockers' );
				if ( 0 == Object.keys( loadingBlockers ).length ) {
					new BuilderView();
				}
			},

			template: function( template ) {
				return _.template( $( template ).html(),  {
					evaluate:    /<#([\s\S]+?)#>/g,
					interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
					escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
					variable:    'data'
				} );
			}
		} );

		var ninjaForms = new NinjaForms();
		ninjaForms.start();
	} );
} );
