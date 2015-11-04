define( ['builder/views/drawerContentViewChangesItem'], function( viewChangesItem ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'ul',
		childView: viewChangesItem,

		onRender: function() {
			// console.log( nfUndoManager );
		}
	} );

	return view;
} );