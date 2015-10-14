define( ['builder/views/mainHeader'], function( mainHeaderView ) {

	var view = Marionette.LayoutView.extend({
		tagName: 'div',
		template: '#nf-tmpl-main',

		regions: {
			header: '#nf-main-header',
			content: '#nf-main-content'
		},

		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:domain', this.render );
		},

		onShow: function() {
			jQuery( this.el ).parent().perfectScrollbar();
		},

		onRender: function() {
			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
			var headerView = currentDomain.get( 'getMainHeaderView' ).call( currentDomain );
			this.header.show( headerView );
			var contentView = currentDomain.get( 'getMainContentView' ).call( currentDomain );
			this.content.show( contentView );
		}

	});

	return view;
} );