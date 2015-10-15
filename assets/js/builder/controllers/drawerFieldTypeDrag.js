define( [], function( ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'startDrag:fieldType', this.overflowVisible );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stopDrag:fieldType', this.resetOverflow );
		},

		overflowVisible: function() {
			this.drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'visible', 'important' );
		},

		resetOverflow: function() {
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'hidden', 'important' );
		},

	});

	return controller;
} );