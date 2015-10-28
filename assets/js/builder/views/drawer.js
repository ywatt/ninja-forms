define( ['builder/views/drawerHeader', 'builder/views/drawerContentEmpty'], function( drawerHeaderView, drawerEmptyView ) {

	var view = Marionette.LayoutView.extend( {
		template: '#nf-tmpl-drawer',

		regions: {
			header: '#nf-drawer-header',
			content: '#nf-drawer-content'
		},

		initialize: function() {
			nfRadio.channel( 'app' ).reply( 'get:drawerEl', this.getEl, this );
			nfRadio.channel( 'drawer' ).reply( 'load:drawerContent', this.loadContent, this );
			nfRadio.channel( 'drawer' ).reply( 'empty:drawerContent', this.emptyContent, this );
		},

		onShow: function() {
			// var closedRightPos = nfRadio.channel( 'drawer' ).request( 'get:closedRightPos' );
			// jQuery( this.el ).parent().css( { 'right': closedRightPos } );

			this.header.show( new drawerHeaderView() );
			jQuery( this.el ).parent().perfectScrollbar();
		    jQuery( this.el ).parent().disableSelection();
		},

		loadContent: function( drawerID, data ) {
			var drawer = nfRadio.channel( 'app' ).request( 'get:drawer', drawerID );
			var view = drawer.get( 'getView' ).call( drawer, data );
			this.content.show( view );
		},

		emptyContent: function() {
			this.content.show( new drawerEmptyView() );
		},

		getEl: function() {
			return jQuery( this.el ).parent();
		},

		events: {
			'click .nf-toggle-drawer': 'clickToggleDrawer'
		},

		clickToggleDrawer: function() {
			nfRadio.channel( 'drawer' ).trigger( 'click:toggleDrawerSize' );
		}

	} );

	return view;
} );