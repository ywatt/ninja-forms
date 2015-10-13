define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-app-menu-item',

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );
		},

		events: {
			'click a': 'clickAppMenu'
		},

		clickAppMenu: function( e ) {
			nfRadio.channel( 'app' ).trigger( 'click:appMenu', this.model );
		}

	});

	return view;
} );