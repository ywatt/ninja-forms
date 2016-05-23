/**
 * Handles submission of our form.
 */
define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'forms' ), 'init:model', this.registerSubmitHandler );
		},

		/**
		 * Register the submission handler function.
		 * 
		 * @since  3.0
		 * @param  Backbone.model 	formModel
		 * @return void
		 */
		registerSubmitHandler: function( formModel ) {
			nfRadio.channel( 'form-' + formModel.get( 'id' ) ).reply( 'submit', this.submit );
		},

		/**
		 * Handles the actual submission of our form.
		 * When we submit:
		 *
		 * 1) Send out a message saying that we're about to begin form submission.
		 * 2) Check the form for errors
		 * 3) Submit the data
		 * 4) Send out a message with our response
		 * 
		 * @since  3.0
		 * @param  Backbone.model 	formModel
		 * @return void
		 */
		submit: function( formModel ) {
			/*
			 * Send out a radio message saying that we're about to begin submitting.
			 * First we send on the generic forms channel, and then on the form-specific channel.
			 */
			nfRadio.channel( 'forms' ).trigger( 'before:submit', formModel );
			nfRadio.channel( 'form-' + formModel.get( 'id' ) ).trigger( 'before:submit', formModel );

			/*
			 * Loop through our fields, sending out a message asking them to validate.
			 */
			// _.each( formModel.get( 'fields' ).models, function( field ) {
			// 	nfRadio.channel( 'submit' ).trigger( 'validate:field', field );
			// 	nfRadio.channel( field.get( 'type' ) ).trigger( 'before:submit', field );
			// 	nfRadio.channel( 'fields' ).trigger( 'before:submit', field );
			// } );

			/*
			 * Make sure we don't have any form errors before we submit.
			 * Return false if we do.
			 */
			if ( 0 != formModel.get( 'errors' ).models.length ) {
				nfRadio.channel( 'forms' ).trigger( 'submit:failed', formModel );
				nfRadio.channel( 'form-' + formModel.get( 'id' ) ).trigger( 'submit:failed', formModel );
				return false;
			}

		}

	});

	return controller;
} );