define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-content-view-changes-item',

		onRender: function() {
			console.log( 'render' );
		}
	});

	return view;
} );