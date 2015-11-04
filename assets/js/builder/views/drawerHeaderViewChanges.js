define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-header-view-changes',

		events: {
			'click .cancelChanges': 'clickCancelChanges'
		},

		clickCancelChanges: function( e ) {
			nfRadio.channel( 'drawer' ).trigger( 'click:cancelChanges' );
		}
	});

	return view;
} );