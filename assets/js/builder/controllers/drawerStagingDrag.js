define( [], function( ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'startDrag:fieldStaging', this.startDrag );
			this.listenTo( nfRadio.channel( 'drawer' ), 'stopDrag:fieldStaging', this.stopDrag );
		},

		startDrag: function( context, ui ) {
			this.drawerEl = nfRadio.channel( 'app' ).request( 'get:drawerEl' );
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'visible', 'important' );
			var html = _.template( jQuery( '#nf-tmpl-staged-fields-drag' ).html() );
			jQuery( ui.helper ).html( html );
			jQuery( ui.item ).css( 'opacity', '0.7' );
		},

		stopDrag: function( context, ui ) {
			jQuery( this.drawerEl )[0].style.setProperty( 'overflow', 'hidden', 'important' );
		}
	});

	return controller;
} );