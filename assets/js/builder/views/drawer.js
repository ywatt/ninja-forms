define( [], function() {

	var view = Marionette.LayoutView.extend( {
		template: "#nf-tmpl-drawer",

		regions: {
			header: ".nf-drawer-header"
		},

		initialize: function() {
			this.render();
		}

	} );

	return view;
} );