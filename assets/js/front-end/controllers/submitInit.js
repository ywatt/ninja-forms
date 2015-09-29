define(['lib/backbone.radio', 'front-end/controllers/submitButton'], function( Radio, submitButton ) {
	var radioChannel = Radio.channel( 'submit' );
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'init:model', this.registerSubmit );
		},

		registerSubmit: function( model ) {
			model.set( 'maybeRenderError', this.maybeRenderError );
			new submitButton( model );
		},

		maybeRenderError: function() {
			if ( Radio.channel( 'form' ).request( 'get:errors', this.formID ) ) {
				return _.template( jQuery( '#nf-tmpl-field-submit-error-msg' ).html(), this );
			} else {
				return '';
			}
			
		}

	});

	return controller;
} );