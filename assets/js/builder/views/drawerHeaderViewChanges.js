define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-header-view-changes',

		events: {
			'click .undoChanges': 'clickUndoChanges'
		},

		clickUndoChanges: function( e ) {
			nfRadio.channel( 'drawer' ).trigger( 'click:undoChanges' );
		}
	});

	return view;
} );