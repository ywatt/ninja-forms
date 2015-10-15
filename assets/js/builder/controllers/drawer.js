define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'click:openDrawer', this.openDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:closeDrawer', this.closeDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:toggleDrawerSize', this.toggleDrawerSize );

			nfRadio.channel( 'app' ).reply( 'open:drawer', this.openDrawer, this );
			nfRadio.channel( 'app' ).reply( 'close:drawer', this.closeDrawer, this );

			nfRadio.channel( 'drawer' ).reply( 'is:moving', this.isMoving, this );

			this.moving = false;
		},

		closeDrawer: function() {
			if ( this.moving ) {
				return false;
			}

			this.moving = true;

			var builderEl = nfRadio.channel( 'app' ).request( 'get:builderEl' );
			jQuery( builderEl ).addClass( 'nf-drawer-closed' ).removeClass( 'nf-drawer-opened' );
			nfRadio.channel( 'drawer' ).request( 'clear:filter' );
			
			var triggered = false;
			var that = this;
			jQuery( builderEl ).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',   
			    function(e) {
			    	if ( ! triggered ) {
			    		nfRadio.channel( 'app' ).request( 'update:currentDrawer', false );
			    		nfRadio.channel( 'drawer' ).trigger( 'close:drawer' );
			    		triggered = true;
			    		that.moving = false;
			    	}
				}
			);
		},

		openDrawer: function( e ) {
			if ( this.moving ) {
				return false;
			}

			this.moving = true;
			/*
			 * 1) Before we open the drawer, we need to get the drawer ID.
			 * 2) Send out a message requesting the drawer content be loaded.
			 * 3) Update our appData model with the current drawer.
			 */
			var drawerID = jQuery( e.target ).data( 'drawerid' );
			nfRadio.channel( 'drawer' ).request( 'load:drawerContent', drawerID );

			var builderEl = nfRadio.channel( 'app' ).request( 'get:builderEl' );
			jQuery( builderEl ).addClass( 'nf-drawer-opened' ).removeClass( 'nf-drawer-closed' );
			
			var that = this;
			var triggered = false;
			jQuery( builderEl ).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',   
			    function(e) {
			    	if ( ! triggered ) {
			    		nfRadio.channel( 'app' ).request( 'update:currentDrawer', drawerID );
			    		nfRadio.channel( 'drawer' ).trigger( 'open:drawer' );
			    		that.focusFilter();
			    		triggered = true;
			    		that.moving = false;
			    	}
				}
			);
		},

		toggleDrawerSize: function() {
			var drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( drawerEl ).toggleClass( 'nf-drawer-expand' );
		},

		isMoving: function() {
			return this.moving;
		},

        focusFilter: function() {
        	var filterEl = nfRadio.channel( 'drawer' ).request( 'get:filterEl' );
        	jQuery( filterEl ).focus();
        }
	});

	return controller;
} );