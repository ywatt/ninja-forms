define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main-content-loading',

		onShow: function() {
			jQuery( this.el ).fadeIn( 1500 );
		},

		onBeforeDestroy: function() {
			jQuery( this.el ).fadeOut( 300 );
		}
	});

	return view;
} );
