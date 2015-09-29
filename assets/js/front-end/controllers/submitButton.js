define(['lib/backbone.radio'], function( Radio ) {
	var controller = Marionette.Object.extend( {
		initialize: function( model ) {
			this.model = model;
			var formChannel = Radio.channel( 'form-' + model.get( 'formID' ) );
			var fieldsChannel = Radio.channel( 'fields' )
			this.listenTo( fieldsChannel, 'add:error', this.updateSubmit, this );
			this.listenTo( fieldsChannel, 'remove:error', this.updateSubmit, this );
			this.listenTo( fieldsChannel, 'click:field', this.displayError, this );

			this.listenTo( formChannel, 'disable:submit', this.disableSubmit, this );
			this.listenTo( formChannel, 'enable:submit', this.enableSubmit, this );
		},

		updateSubmit: function( model, id, msg ) {
			if ( ( model.get( 'id' ) !== this.model.get( 'id' ) ) && ( model.get( 'formID' ) == this.model.get( 'formID' ) ) ) {
				if ( Radio.channel( 'form' ).request( 'get:errors', model.get( 'formID' ) ) ) {
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

		displayError: function( el, model ) {
			if ( model.get( 'id' ) == this.model.get( 'id' ) && Radio.channel( 'form' ).request( 'get:errors', this.model.get( 'formID' ) ) ) {
				jQuery( el ).closest( '.nf-field-wrap' ).find( '.nf-field-submit-error' ).show();
			}
		}
	});

	return controller;
} );