define( ['builder/views/mainHeader', 'builder/views/mainContent'], function( mainHeaderView, mainContentView ) {

	var view = Marionette.LayoutView.extend({
		tagName: "div",
		template: "#nf-tmpl-main",

		regions: {
			header: "#nf-main-header",
			content: "#nf-main-content"
		},

		onShow: function() {
			this.header.show( new mainHeaderView() );
			this.header.show( new mainContentView() );
		}

	});

	return view;
} );