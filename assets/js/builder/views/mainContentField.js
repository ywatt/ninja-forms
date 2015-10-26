define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main-content-field',

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );

			// jQuery( this.el ).hide();
		},

		onShow: function() {
			// jQuery( this.el ).fadeIn( 'fast' );
		},

		events: {
			'click .nf-edit-settings': 'openDrawer'
		},

		openDrawer: function( e ) {
			nfRadio.channel( 'app' ).request( 'open:drawer', 'editField' );
		}

	});

	return view;
} );