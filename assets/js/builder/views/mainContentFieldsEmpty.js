define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main-content-fields-empty',

		onBeforeDestroy: function() {
			jQuery( this.el ).fadeOut();
		}
	});

	return view;
} );