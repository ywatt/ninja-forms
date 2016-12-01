jQuery( document ).ready( function( $ ) {
	var nfFormApp = Marionette.Application.extend( {
		
		initialize: function( formID ) {
			this.formID = formID;
		},

		onStart: function() {
			console.log( this.formID );
		}

	} );

	var NinjaForms = Marionette.Application.extend( {
		
		initialize: function() {
			console.log( 'init main app' );
		},

		/**
		 * When we start our main app, boot up an app for each form in our form list.
		 * @since  3.0
		 * @return {void}
		 */
		onStart: function() {
			_.each( nfFrontEnd.form_list, function( formID ) {
				
			} );
		}

	} );

	var ninjaForms = new NinjaForms();
	ninjaForms.start();

} );