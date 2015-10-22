define( [], function( ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'startDrag:fieldType', this.startDrag );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stopDrag:fieldType', this.stopDrag );

			nfRadio.channel( 'app' ).reply( 'get:fieldTypeHelperClone', this.getCurrentDraggableHelperClone, this );
		},

		startDrag: function( context, ui ) {
			this.drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'visible', 'important' );

			this.draggableHelperClone = jQuery( ui.helper ).clone();
			
		},

		stopDrag: function( context, ui ) {
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'hidden', 'important' );
		},

		getCurrentDraggableHelperClone: function() {
			return this.draggableHelperClone;
		}
	});

	return controller;
} );