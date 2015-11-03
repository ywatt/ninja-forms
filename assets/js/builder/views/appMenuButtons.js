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
	    			if ( nfRadio.channel( 'app' ).request( 'get:appSetting', 'clean' ) ) {
	    				return 'disabled';
	    			} else {
	    				return '';
	    			}
	    		},

	    		maybeRenderCancel: function() {
	    			if ( ! nfRadio.channel( 'app' ).request( 'get:appSetting', 'clean' ) ) {
	    				return _.template( jQuery( '#nf-tmpl-app-header-cancel' ).html(), this );	    				
	    			} else {
	    				return '';
	    			}
				},
			};
		},

		events: {
			'click .publish': 'clickPublish',
			'click .cancel': 'clickCancel'
		},

		clickPublish: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:publish', e );
		},

		clickCancel: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:cancelChanges', e );
		}

	});

	return view;
} );