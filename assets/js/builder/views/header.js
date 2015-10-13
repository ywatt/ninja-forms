define( ['builder/views/appHeader'], function( appHeaderView ) {

	var view = Marionette.LayoutView.extend({
		tagName: "div",
		template: "#nf-tmpl-header",

		regions: {
			app: "#nf-app-header",
			appSub: "#nf-app-sub-header"
		},

		onShow: function() {
			this.app.show( new appHeaderView() );
		},

		events: {
			'click .nf-open-drawer': 'openDrawer'
		},

		openDrawer: function() {
			nfRadio.channel( 'drawer' ).trigger( 'click:openDrawer' );
		}

	});

	return view;
} );