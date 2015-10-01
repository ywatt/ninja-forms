define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'blur:field', this.validateRequired );
			this.listenTo( nfRadio.channel( 'fields' ), 'change:field', this.validateRequired );
			this.listenTo( nfRadio.channel( 'fields' ), 'keyup:field', this.validateKeyup );

			this.listenTo( nfRadio.channel( 'submit' ), 'validate:field', this.beforeSubmit );
		},
		
		validateKeyup: function( el, model, keyCode ) {
			var errorExists = nfRadio.channel( 'fields' ).request( 'get:error', model.get( 'id' ), 'required-error' );
			if ( errorExists ) {
				this.validateRequired( el, model );
			}
		},

		validateRequired: function( el, model ) {
			if ( 1 != model.get( 'required' ) ) {
				return false;
			}
			
			var currentValue = jQuery( el ).val();
			var customReqValidation = nfRadio.channel( model.get( 'type' ) ).request( 'validate:required', el, model );
			var defaultReqValidation = true;

			if ( ! jQuery.trim( currentValue ) ) {
				defaultReqValidation = false;
			}

			if ( 'undefined' !== typeof customReqValidation ) {
				var valid = customReqValidation;
			} else {
				var valid = defaultReqValidation;
			}

			if ( ! valid ) {
				nfRadio.channel( 'fields' ).request( 'add:error', model.get( 'id' ), 'required-error', 'This is a required field.' );
			} else {
				nfRadio.channel( 'fields' ).request( 'remove:error', model.get( 'id' ), 'required-error' );
			}
		},

		beforeSubmit: function( model ) {
			if ( 1 != model.get( 'required' ) ) {
				return false;
			}

			currentValue = model.get( 'value' );
			
			var defaultReqValidation = true;

			if ( ! jQuery.trim( currentValue ) ) {
				defaultReqValidation = false;
			}

			var valid = defaultReqValidation;
			
			if ( ! valid ) {
				nfRadio.channel( 'fields' ).request( 'add:error', model.get( 'id' ), 'required-error', 'This is a required field.' );
			} else {
				nfRadio.channel( 'fields' ).request( 'remove:error', model.get( 'id' ), 'required-error' );
			}

		}
	});

	return controller;
} );