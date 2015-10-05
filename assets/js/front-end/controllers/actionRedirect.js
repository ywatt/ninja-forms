define([], function() {
	var radioChannel = nfRadio.channel( 'submit' );
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'submit:response', this.actionRedirect );
		},

		actionRedirect: function( response ) {
			if ( _.size( response.errors ) == 0 ) {
				if ( 'undefined' != typeof response.data.redirect && '' != response.data.redirect ) {
					window.location = response.data.redirect;
				}
			}
		}

	});

	return controller;
} );