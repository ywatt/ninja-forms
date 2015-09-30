define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function( model ) {
			this.model = model;
			var formChannel = nfRadio.channel( 'form-' + model.get( 'formID' ) );
			var fieldsChannel = nfRadio.channel( 'fields' )

			this.listenTo( fieldsChannel, 'add:error', this.updateSubmit, this );
			this.listenTo( fieldsChannel, 'remove:error', this.updateSubmit, this );
			this.listenTo( fieldsChannel, 'click:field', this.submitForm, this );

			this.listenTo( formChannel, 'disable:submit', this.disableSubmit, this );
			this.listenTo( formChannel, 'enable:submit', this.enableSubmit, this );
		},

		updateSubmit: function( model, id, msg ) {
			if ( ( model.get( 'id' ) !== this.model.get( 'id' ) ) && ( model.get( 'formID' ) == this.model.get( 'formID' ) ) ) {
				if ( nfRadio.channel( 'form' ).request( 'get:errors', model.get( 'formID' ) ) ) {
					this.disableSubmit( model, id, msg );
				} else {
					this.enableSubmit( model, id );
				}
			}
		},

		disableSubmit: function( model, id, msg ) {
			this.model.set( 'disabled', 'disabled' );
			this.model.set( 'reRender', true );
		},

		enableSubmit: function( model, id ) {
			this.model.set( 'disabled', '' );
			this.model.set( 'reRender', true );
		},

		submitForm: function( el, model ) {
			if ( model.get( 'id' ) != this.model.get( 'id' ) ) {
				return false;
			}

			if ( nfRadio.channel( 'form' ).request( 'get:errors', this.model.get( 'formID' ) ) ) {
				jQuery( el ).closest( '.nf-field-wrap' ).find( '.nf-field-submit-error' ).show();
			} else {
				var formModel = nfRadio.channel( 'form' ).request( 'get:form', model.get( 'formID' ) );
				var formData = JSON.stringify( formModel );
				console.log( formData );	
				jQuery.ajax({
                    url: nfFrontEnd.adminAjax,
                    type: 'POST',
                    data: {
                    	action: 'nf_ajax_submit',
                    	security: nfFrontEnd.ajaxNonce,
                    	formData: formData
                    },
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR)
                    {
                        if(typeof data.error === 'undefined')
                        {
                            // Success so call function to process the form
//                            submitForm(event, data);
                        }
                        else
                        {
                            // Handle errors here
                            console.log('ERRORS: ' + data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                });
			}
		}
	});

	return controller;
} );