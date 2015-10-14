define( ['builder/views/appHeader', 'builder/views/appSubHeader'], function( appHeaderView, appSubHeaderView ) {

	var view = Marionette.LayoutView.extend({
		tagName: "div",
		template: "#nf-tmpl-header",

		regions: {
			app: "#nf-app-header",
			appSub: "#nf-app-sub-header"
		},

		onShow: function() {
			this.app.show( new appHeaderView() );
			this.appSub.show( new appSubHeaderView() );
		}
	});

	return view;
} );