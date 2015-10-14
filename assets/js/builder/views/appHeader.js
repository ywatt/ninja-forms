define( ['builder/views/appMenu'], function( appMenuCollectionView ) {
	var view = Marionette.LayoutView.extend( {
		tagName: 'div',
		template: '#nf-tmpl-app-header',

		regions: {
			menu: '.nf-app-menu'
		},

		onShow: function() {
			var appMenuCollection = nfRadio.channel( 'app' ).request( 'get:appMenuCollection' );
			this.menu.show( new appMenuCollectionView( { collection: appMenuCollection } ) );
		}
	} );

	return view;
} );