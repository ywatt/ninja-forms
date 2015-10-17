define( ['builder/views/header', 'builder/views/main', 'builder/views/menuDrawer', 'builder/views/drawer'], function( headerView, mainView, menuDrawerView, drawerView ) {

	var view = Marionette.LayoutView.extend( {
		template: "#nf-tmpl-builder",
		el: '#nf-builder',

		regions: {
			header: "#nf-header",
			main: "#nf-main",
			menuDrawer: "#nf-menu-drawer",
			drawer: "#nf-drawer"
		},

		initialize: function() {
			this.render();
			this.header.show( new headerView() );
			this.main.show( new mainView() );
			// this.menuDrawer.show( new menuDrawerView() );
			this.drawer.show( new drawerView() );

			nfRadio.channel( 'app' ).reply( 'get:builderEl', this.getBuilderEl, this );
		},

		getBuilderEl: function() {
			return this.el;
		},

		events: {
			'click .nf-open-drawer': 'openDrawer',
			'click .nf-change-domain': 'changeDomain'
		},

		openDrawer: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:openDrawer', e );
		},

		changeDomain: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:changeDomain', e );
		}

	} );

	return view;
} );