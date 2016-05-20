define(['controllers/submitButton'], function( submitButton ) {
	var radioChannel = nfRadio.channel( 'submit' );
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'init:model', this.registerSubmit );
		},

		registerSubmit: function( model ) {
			new submitButton( model );
		}

	});

	return controller;
} );