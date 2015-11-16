/**
 * Renders the action buttons to the right of the app menu. i.e. Publish
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'span',
		template: '#nf-tmpl-app-header-action-button',

		initialize: function() {
			// Listen to changes on the app 'clean' state. When it changes, re-render.
			this.listenTo( nfRadio.channel( 'app' ), 'change:clean', this.render, this );
		},

		/**
		 * These functions are available to templates, and help us to remove logic from template files.
		 * 
		 * @since  3.0
		 * @return Object
		 */
		templateHelpers: function () {
	    	return {
	    		/**
	    		 * If our app state is clean, disable publish.
	    		 * 
	    		 * @since  3.0
	    		 * @return string
	    		 */
	    		maybeDisabled: function() {
	    			if ( nfRadio.channel( 'app' ).request( 'get:setting', 'clean' ) ) {
	    				return 'disabled';
	    			} else {
	    				return '';
	    			}
	    		},

	    		/**
	    		 * If our app isn't clean, render our 'viewChanges' button.
	    		 * @since  version
	    		 * @return {[type]} [description]
	    		 */
	    		maybeRenderCancel: function() {
	    			if ( ! nfRadio.channel( 'app' ).request( 'get:setting', 'clean' ) ) {
	    				return _.template( jQuery( '#nf-tmpl-app-header-view-changes' ).html(), this );	    				
	    			} else {
	    				return '';
	    			}
				},
			};
		},

		/**
		 * Listen for clicks on the Publish or view changes button.
		 * @type {Object}
		 */
		events: {
			'click .publish': 'clickPublish',
			'click .viewChanges': 'clickViewChanges'
		},

		/**
		 * When we click publish, trigger a radio event.
		 * This lets us separate the logic from the click event and view.
		 * 
		 * @since  3.0
		 * @param  Object 	e event
		 * @return void
		 */
		clickPublish: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:publish', e );
		},

		/**
		 * When we click view changes, trigger a radio event.
		 * This lets us separate the logic from the click event and view.
		 * 
		 * @since  3.0
		 * @param  Object 	e event
		 * @return void
		 */
		clickViewChanges: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:viewChanges', e );
		}

	});

	return view;
} );