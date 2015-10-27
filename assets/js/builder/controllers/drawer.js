define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'click:openDrawer', this.maybeOpenDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:closeDrawer', this.closeDrawer );
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:toggleDrawerSize', this.toggleDrawerSize );

			nfRadio.channel( 'app' ).reply( 'open:drawer', this.openDrawer, this );
			nfRadio.channel( 'app' ).reply( 'close:drawer', this.closeDrawer, this );
		},

		closeDrawer: function() {
			nfRadio.channel( 'drawer' ).trigger( 'before:closeDrawer' );
			nfRadio.channel( 'drawer' ).request( 'empty:drawerContent' );

			var builderEl = nfRadio.channel( 'app' ).request( 'get:builderEl' );
			jQuery( builderEl ).addClass( 'nf-drawer-closed' ).removeClass( 'nf-drawer-opened' );

			var rightClosed = this.getClosedDrawerRight();

			var drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( drawerEl ).css( { 'right': rightClosed } );

			nfRadio.channel( 'drawer' ).request( 'clear:filter' );
			nfRadio.channel( 'drawer' ).request( 'blur:filter' );
						
			var that = this;

			this.checkCloseDrawerPos = setInterval( function() {
	        	if ( rightClosed == jQuery( drawerEl ).css( 'right' ) ) {
	        		clearInterval( that.checkCloseDrawerPos );
		    		nfRadio.channel( 'app' ).request( 'update:currentDrawer', false );
		    		nfRadio.channel( 'drawer' ).trigger( 'close:drawer' );
	        	}
			}, 150 );
		},

		maybeOpenDrawer: function( e ) {
			var drawerID = jQuery( e.target ).data( 'drawerid' );
			this.openDrawer( drawerID );
		},

		openDrawer: function( drawerID, data ) {
			/*
			 * 2) Send out a message requesting the drawer content be loaded.
			 * 3) Update our appData model with the current drawer.
			 */
			
			data = data || false;

			nfRadio.channel( 'drawer' ).request( 'load:drawerContent', drawerID, data );

			var builderEl = nfRadio.channel( 'app' ).request( 'get:builderEl' );
			jQuery( builderEl ).addClass( 'nf-drawer-opened' ).removeClass( 'nf-drawer-closed' );

			var drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( drawerEl ).css( { 'right': '0px' } );
			
			var that = this;

			this.checkOpenDrawerPos = setInterval( function() {
	        	if ( '0px' == jQuery( drawerEl ).css( 'right' ) ) {
	        		clearInterval( that.checkOpenDrawerPos );
	        		that.focusFilter();
		    		nfRadio.channel( 'app' ).request( 'update:currentDrawer', drawerID );
		    		nfRadio.channel( 'drawer' ).trigger( 'open:drawer' );
	        	}
			}, 150 );
		},

		toggleDrawerSize: function() {
			var drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( drawerEl ).toggleClass( 'nf-drawer-expand' );
		},

        focusFilter: function() {
        	var filterEl = nfRadio.channel( 'drawer' ).request( 'get:filterEl' );
        	jQuery( filterEl ).focus();
        },

        getClosedDrawerRight: function() {
			var builderEl = nfRadio.channel( 'app' ).request( 'get:builderEl' );
			return '-' + jQuery( builderEl ).width() + 'px';
        }
	});

	return controller;
} );