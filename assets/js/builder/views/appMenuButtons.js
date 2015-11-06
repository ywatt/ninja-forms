define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'span',
		template: '#nf-tmpl-app-header-action-button',

		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:clean', this.render, this );
		},

		templateHelpers: function () {
	    	return {
	    		maybeDisabled: function() {
	    			if ( nfRadio.channel( 'app' ).request( 'get:setting', 'clean' ) ) {
	    				return 'disabled';
	    			} else {
	    				return '';
	    			}
	    		},

	    		maybeRenderCancel: function() {
	    			if ( ! nfRadio.channel( 'app' ).request( 'get:setting', 'clean' ) ) {
	    				return _.template( jQuery( '#nf-tmpl-app-header-view-changes' ).html(), this );	    				
	    			} else {
	    				return '';
	    			}
				},
			};
		},

		events: {
			'click .publish': 'clickPublish',
			'click .viewChanges': 'clickViewChanges'
		},

		clickPublish: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:publish', e );
		},

		clickViewChanges: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:viewChanges', e );
		}

	});

	return view;
} );