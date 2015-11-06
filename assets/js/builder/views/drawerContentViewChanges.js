define( ['builder/views/drawerContentViewChangesItem'], function( viewChangesItem ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'ul',
		childView: viewChangesItem,

		onRender: function() {
			
		}
	} );

	return view;
} );