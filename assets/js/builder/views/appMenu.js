define( ['builder/views/appMenuItem'], function( appMenuItemView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: appMenuItemView,

		onShow: function() {
			jQuery( this.el ).find( 'li:last' ).unwrap();
		}
	} );

	return view;
} );