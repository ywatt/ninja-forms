define( ['builder/views/appMenu', 'builder/views/appMenuButtons'], function( appMenuCollectionView, appMenuButtonsView ) {
	var view = Marionette.LayoutView.extend( {
		tagName: 'div',
		template: '#nf-tmpl-app-header',

		regions: {
			menu: '.nf-app-menu',
			buttons: '.nf-app-buttons'
		},

		onShow: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:domainCollection' );
			this.menu.show( new appMenuCollectionView( { collection: appDomainCollection } ) );
		
			this.buttons.show( new appMenuButtonsView() );
		}
	} );

	return view;
} );