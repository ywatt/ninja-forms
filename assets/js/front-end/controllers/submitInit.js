define(['lib/backbone.radio', 'front-end/controllers/submitError'], function( Radio, submitError ) {
	var radioChannel = Radio.channel( 'submit' );
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'init:model', this.registerSubmit );
		},

		registerSubmit: function( model ) {
			new submitError( model );
		}

	});

	return controller;
} );