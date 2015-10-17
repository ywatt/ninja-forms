define( ['builder/views/mainContentField', 'builder/views/mainContentFieldsEmpty'], function( mainContentFieldView, mainContentFieldEmptyView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: mainContentFieldView,
		emptyView: mainContentFieldEmptyView,

		onRender: function() {
			jQuery( this.el ).hide();
		},

		onShow: function() {
			jQuery( this.el ).fadeIn();
			jQuery( this.el ).addClass( 'nf-fields-sortable' );
			jQuery( this.el ).sortable( {
				containment: 'parent',
				
				receive: function( e, ui ) {
					jQuery( ui.helper ).attr( 'style', '' );
					console.log( jQuery( e.target ).parent().parent().parent() );
				},

				cancel: '.nf-item-controls'
			} );
		}

	} );

	return view;
} );