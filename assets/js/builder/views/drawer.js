define( ['builder/views/drawerHeader'], function( drawerHeaderView ) {

	var view = Marionette.LayoutView.extend( {
		template: '#nf-tmpl-drawer',

		regions: {
			header: '#nf-drawer-header',
			content: '#nf-drawer-content'
		},

		initialize: function() {
			nfRadio.channel( 'app' ).reply( 'get:drawerEl', this.getEl, this );
			nfRadio.channel( 'drawer' ).reply( 'load:drawerContent', this.loadContent, this );
		},
		
		onShow: function() {
			this.header.show( new drawerHeaderView() );
			// this.content.show( new drawerContentView() );
			jQuery( this.el ).parent().perfectScrollbar();
		    jQuery( this.el ).parent().disableSelection();
		},

		loadContent: function( drawerID ) {
			var drawer = nfRadio.channel( 'app' ).request( 'get:drawer', drawerID );
			var view = drawer.get( 'getView' ).call( drawer );
			this.content.show( view );
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