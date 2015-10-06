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
		}

	});

	return view;
} );