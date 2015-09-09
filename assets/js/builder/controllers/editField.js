define( ['lib/backbone.radio'], function( Radio ) {
	var fieldsChannel = Radio.channel( 'fields' );

	var fieldController = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( fieldsChannel, 'editField:editField', this.editField );
		},

		editField: function() {
			jQuery( '#nf-main' ).animate( { 'width': '50%' }, 500 );
			jQuery( '#nf-drawer' ).show( 'slide', { direction: 'right' }, 500 );
		}
	});

	return new fieldController();
} );