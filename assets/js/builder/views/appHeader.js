define( ['builder/views/appMenu'], function( appMenuCollectionView ) {
	var view = Marionette.LayoutView.extend( {
		tagName: 'div',
		template: '#nf-tmpl-app-header',

		regions: {
			menu: '.nf-app-menu'
		},

		onShow: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			this.menu.show( new appMenuCollectionView( { collection: appDomainCollection } ) );
		}
	} );

	return view;
} );