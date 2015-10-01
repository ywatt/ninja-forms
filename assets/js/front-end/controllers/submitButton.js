define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function( model ) {
			this.model = model;
			var formChannel = nfRadio.channel( 'form-' + model.get( 'formID' ) );
			var allFieldsChannel = nfRadio.channel( 'fields' );
			var thisFieldChannel = nfRadio.channel( 'field-' + model.get( 'id' ) );

			this.listenTo( allFieldsChannel, 'add:error', this.updateSubmit, this );
			this.listenTo( allFieldsChannel, 'remove:error', this.updateSubmit, this );
			this.listenTo( thisFieldChannel, 'click:field', this.submitForm, this );

			this.listenTo( formChannel, 'disable:submit', this.disableSubmit, this );
			this.listenTo( formChannel, 'enable:submit', this.enableSubmit, this );
		},

		updateSubmit: function( model, id, msg ) {
			if ( model.get( 'formID' ) == this.model.get( 'formID' ) ) {
				if ( nfRadio.channel( 'form' ).request( 'get:errors', model.get( 'formID' ) ) ) {
					this.disableSubmit( model, id, msg );
				} else {
					this.enableSubmit( model, id );
				}
			}
		},

		disableSubmit: function( model, id, msg ) {
			if ( 'disabled' != this.model.get( 'disabled' ) ) {
				this.model.set( 'disabled', 'disabled' );
				this.model.set( 'reRender', true );				
			}
		},

		enableSubmit: function( model, id ) {
			if ( 'disabled' == this.model.get( 'disabled' ) ) {
				this.model.set( 'disabled', '' );
				this.model.set( 'reRender', true );						
			}
		},

		submitForm: function( el, model ) {
			var formErrors = nfRadio.channel( 'form' ).request( 'get:errors', this.model.get( 'formID' ) );
			if ( formErrors ) {
				jQuery( el ).closest( '.nf-field-wrap' ).find( '.nf-field-submit-error' ).show();
			} else {
				// Get our form model.
				var formModel = nfRadio.channel( 'form' ).request( 'get:form', model.get( 'formID' ) );
				// Before we submit, check to make sure that all of our required fields aren't empty.
				_.each( formModel.get( 'fields' ).models, function( field ) {
					if ( 1 == field.get( 'required' ) && '' == jQuery.trim( field.get( 'value' ) ) ) {
						nfRadio.channel( 'fields' ).request( 'add:error', field.get( 'id' ), 'required-error', 'This is a required field.' );
					}
				} );

				// Check again for form errors.
				formErrors = nfRadio.channel( 'form' ).request( 'get:errors', this.model.get( 'formID' ) );

				if ( formErrors ) {
					return false;
				} else {
					var formData = JSON.stringify( formModel );
					var data = {
	                	'action': 'nf_ajax_submit',
	                	'security': nfFrontEnd.ajaxNonce,
	                	'formData': formData
					}

					jQuery.ajax({
	                    url: nfFrontEnd.adminAjax,
	                    type: 'POST',
	                    data: data,
	                    cache: false,
	                   	success: function(data, textStatus, jqXHR)
	                    {
	                        if(typeof data.error === 'undefined') {
								console.log( data );
	                        } else {
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
		}
	});

	return controller;
} );