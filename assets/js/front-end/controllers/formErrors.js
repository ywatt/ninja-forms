/**
 * If a form has at least one field error, we should disable the submit button and add a form error.
 * If a form had errors, but all the field errors have been removed, we should remove the form error.
 *
 * @since 3.0
 */
define([], function() {
	var controller = Marionette.Object.extend( {
		fieldErrors: {},
		initialize: function() {
			/*
			 * Listen for error messages being added to and removed from fields.
			 */
			this.listenTo( nfRadio.channel( 'fields' ), 'add:error', this.addError );
			this.listenTo( nfRadio.channel( 'fields' ), 'remove:error', this.removeError );

			/*
			 * Respond to requests to get form errors
			 */
			nfRadio.channel( 'form' ).reply( 'get:errors', this.getFieldErrors );
		},

		addError: function( fieldModel, errorID, errorMsg ) {
			/*
			 * We store our errors in this object by field ID so that we don't have to loop over all our fields when we're testing for errors.
			 * They are stored as an object within an array, using the field ID as the key.
			 *
			 * If we haven't setup an array item for this field, set it as an object.
			 */
			if ( 'undefined' == typeof this.fieldErrors[ fieldModel.get( 'id' ) ] ) {
				this.fieldErrors[ fieldModel.get( 'id' ) ] = {};
			}
			// Add an error to our tracking array
			this.fieldErrors[ fieldModel.get( 'id' ) ][ errorID ] = errorMsg;
			/*
			 * We have at least one field error, so submmission should be prevented.
			 * Add a form error.
			 */ 
			nfRadio.channel( 'form-' + fieldModel.get( 'formID' ) ).request( 'add:error', 'field-errors', 'Please correct errors before submitting this form.' );
		},

		removeError: function( fieldModel, errorID ) {
			// Remove this error ID from our tracking array.
			this.fieldErrors[ fieldModel.get( 'id' ) ] = _.omit( this.fieldErrors[ fieldModel.get( 'id' ) ], errorID );
			/*
			 * If we don't have any more error IDs on this field, then we need to remove this field from the array.
			 *
			 * Then, if the fieldErrors tracking array has a length of 0, we remove our form error, because all field errors have been dealt with.
			 */
			if ( 0 == _.size( this.fieldErrors[ fieldModel.get( 'id' ) ] ) ) {
				delete this.fieldErrors[ fieldModel.get( 'id' ) ];
			}

			// console.log( this.fieldErrors.length );

			if ( 0 == _.size( this.fieldErrors ) ) {
				// console.log( 'remove our form error' );
				// Remove our form error.
				nfRadio.channel( 'form-' + fieldModel.get( 'formID' ) ).request( 'remove:error', 'field-errors' );
			}
		},

		getFieldErrors: function( formID ) {
			var formModel = nfRadio.channel( 'app' ).request( 'get:form', formID );
			var errors = false;
			
			if ( formModel ) {
				/*
				 * Check to see if we have any errors on our form model.
				 */
				if ( 0 !== formModel.get( 'errors' ).length ) {
					_.each( formModel.get( 'errors' ).models, function( error ) {
						errors = errors || {};
						errors[ error.get( 'id' ) ] = error.get( 'msg' );
					} );						
				}

				
			}
			return errors;
		}

	});

	return controller;
} );