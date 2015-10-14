define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'click:openDrawer', this.openDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:closeDrawer', this.closeDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:toggleDrawerSize', this.toggleDrawerSize );

			nfRadio.channel( 'app' ).reply( 'open:drawer', this.openDrawer );
			nfRadio.channel( 'app' ).reply( 'close:drawer', this.closeDrawer );
		},

		closeDrawer: function() {
			var builderEl = nfRadio.channel( 'app' ).request( 'get:builderEl' );
			jQuery( builderEl ).removeClass( 'nf-drawer-opened' ).addClass( 'nf-drawer-closed' );
			var triggered = false;
			jQuery( builderEl ).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',   
			    function(e) {
			    	if ( ! triggered ) {
			    		nfRadio.channel( 'drawer' ).trigger( 'close:drawer' );
			    		triggered = true;
			    	}
				}
			);
		},

		openDrawer: function( e ) {
			/*
			 * 1) Before we open the drawer, we need to get the drawer ID.
			 * 2) Send out a message requesting the drawer content be loaded.
			 */
			var drawerID = jQuery( e.target ).data( 'drawerid' );
			nfRadio.channel( 'drawer' ).request( 'load:drawerContent', drawerID );

			var builderEl = nfRadio.channel( 'app' ).request( 'get:builderEl' );
			jQuery( builderEl ).removeClass( 'nf-drawer-closed' ).addClass( 'nf-drawer-opened' );
			var triggered = false;
			jQuery( builderEl ).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',   
			    function(e) {
			    	if ( ! triggered ) {
			    		nfRadio.channel( 'drawer' ).trigger( 'open:drawer' );
			    		triggered = true;
			    	}
				}
			);
		},

		toggleDrawerSize: function() {
			var drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( drawerEl ).toggleClass( 'nf-drawer-expand' );
		}
	});

	return controller;
} );