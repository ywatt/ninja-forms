define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-content-view-changes',

		onRender: function() {
			console.log( nfUndoManager.stack.models );
		}
	});

	return view;
} );