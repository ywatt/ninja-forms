define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'startDrag:fieldType', this.overflowVisible );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stopDrag:fieldType', this.resetOverflow );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:closeDrawer', this.closeDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:openDrawer', this.openDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:toggleDrawerSize', this.toggleDrawerSize );
		},

		overflowVisible: function() {
			this.drawerEl = nfRadio.channel( 'drawer' ).request( 'get:drawerEl' );
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'visible', 'important' );
		},

		resetOverflow: function() {
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'hidden', 'important' );
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

		openDrawer: function() {
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
			var drawerEl = nfRadio.channel( 'drawer' ).request( 'get:drawerEl' );
			jQuery( drawerEl ).toggleClass( 'nf-drawer-expand' );
		}
	});

	return controller;
} );