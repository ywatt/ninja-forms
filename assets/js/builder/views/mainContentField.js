define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main-content-field',

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			jQuery( this.el ).hide();
		},

		onShow: function() {
			jQuery( this.el ).fadeIn( 'fast' );
		}

	});

	return view;
} );