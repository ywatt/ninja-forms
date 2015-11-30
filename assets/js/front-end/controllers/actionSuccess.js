define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'submit' ), 'submit:response', this.actionSubmit );
		},

		actionSubmit: function( response ) {
			if ( _.size( response.errors ) == 0 && 'undefined' != typeof response.data.actions ) {
				if ( 'undefined' != typeof response.data.actions.success_message && '' != response.data.actions.success_message ) {
					jQuery( '.nf-response-msg' ).html( response.data.actions.success_message );
				}
			}

			if ( 1 == response.data.settings.clear_successfully_created_form ) {
				console.log( 'clear form' );
			}

			if ( 1 == response.data.settings.hide_successfully_completed_form ) {
				console.log( 'hide form' );
			}
		}

	});

	return controller;
} );