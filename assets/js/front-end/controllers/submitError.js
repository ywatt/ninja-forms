define(['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'fields' );
	var controller = Marionette.Object.extend( {
		initialize: function( model ) {
			this.model = model;
			this.listenTo( radioChannel, 'add:error', this.updateSubmit, this );
			this.listenTo( radioChannel, 'remove:error', this.updateSubmit, this );
			this.listenTo( radioChannel, 'disable:submit', this.disableSubmit, this );
			this.listenTo( radioChannel, 'enable:submit', this.enableSubmit, this );
			// this.listenTo( radioChannel, 'disable:submit', this.disableSubmit, this );
			// this.listenTo( radioChannel, 'enable:submit', this.enableSubmit, this );
		},

		updateSubmit: function( model, id, msg ) {
			if ( model.get( 'formID' ) == this.model.get( 'formID' ) ) {
				var errors = Radio.channel( 'form' ).request( 'get:errors', model.get( 'formID' ) );

				if ( errors ) {
					this.model.set( 'disabled', 'disabled' );
					this.model.set( 'reRender', true );
				} else {
					this.model.set( 'disabled', '' );
					this.model.set( 'reRender', true );
				}
			}
		},

		disableSubmit: function( formID ) {
			if ( this.model.get( 'formID' ) == formID ) {
				console.log( this.model.get( 'label' ) );
				this.model.set( 'disabled', 'disabled' );
				this.model.set( 'reRender', true );
			}
		},

		enableSubmit: function( formID ) {
			if ( this.model.get( 'formID' ) == formID ) {
				this.model.set( 'disabled', '' );
				this.model.set( 'reRender', true );
			}
		}
	});

	return controller;
} );