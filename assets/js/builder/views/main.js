define( ['builder/views/mainHeader'], function( mainHeaderView ) {

	var view = Marionette.LayoutView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main',

		regions: {
			header: '#nf-main-header',
			content: '#nf-main-content'
		},

		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:appDomain', this.render );
			nfRadio.channel( 'app' ).reply( 'get:mainEl', this.getMainEl, this );
		},

		onShow: function() {
			jQuery( this.el ).parent().perfectScrollbar();
			nfRadio.channel( 'main' ).trigger( 'show:main' );
		},

		onRender: function() {
			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );

			var headerView = currentDomain.get( 'getMainHeaderView' ).call( currentDomain );
			this.header.show( headerView );

			var contentView = currentDomain.get( 'getMainContentView' ).call( currentDomain );
			this.content.show( contentView );
		},

		getMainEl: function() {
			return jQuery( this.el ).parent();
		}

	});

	return view;
} );