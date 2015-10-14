define( ['builder/views/mainHeader', 'builder/views/mainContent', 'builder/views/mainFields'], function( mainHeaderView, mainContentView, mainFieldsView ) {

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
			this.header.show( new mainHeaderView() );
			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
			var view = currentDomain.get( 'getView' ).call( currentDomain );
			this.content.show( view );
		}

	});

	return view;
} );