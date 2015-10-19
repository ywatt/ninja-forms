define( ['builder/views/drawerFieldTypeSection'], function( fieldTypeSectionView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: fieldTypeSectionView,

		onShow: function() {
			jQuery( this.el ).find( '.nf-settings' ).unwrap();
		}
	} );

	return view;
} );