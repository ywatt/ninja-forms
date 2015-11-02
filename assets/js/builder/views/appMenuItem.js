define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-app-menu-item',

		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:appDomain', this.render );
			this.model.on( 'change', this.render, this );
		},

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