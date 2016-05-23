define(['controllers/submitButton'], function( submitButton ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'submit' ), 'init:model', this.registerHandlers );
		},

		registerHandlers: function( fieldModel ) {
			this.listenTo( nfRadio.channel( 'field-' + fieldModel.get( 'id' ) ), 'click:field', this.click, this );
			/*
			 * Register an interest in the 'before:submit' event of our form.
			 */
			fieldModel.listenTo( nfRadio.channel( 'form-' + fieldModel.get( 'formID' ) ), 'before:submit', this.beforeSubmit, fieldModel );
			fieldModel.listenTo( nfRadio.channel( 'form-' + fieldModel.get( 'formID' ) ), 'submit:failed', this.submitFailed, fieldModel );
			fieldModel.listenTo( nfRadio.channel( 'form-' + fieldModel.get( 'formID' ) ), 'add:error', this.maybeDisable, fieldModel );
			fieldModel.listenTo( nfRadio.channel( 'form-' + fieldModel.get( 'formID' ) ), 'remove:error', this.maybeEnable, fieldModel );
		},

		click: function( e, fieldModel ) {
			var formModel = nfRadio.channel( 'app' ).request( 'get:form', fieldModel.get( 'formID' ) );
			nfRadio.channel( 'form-' + fieldModel.get( 'formID' ) ).request( 'submit', formModel );
		},

		beforeSubmit: function() {
			this.set( 'disabled', true );
			this.set( 'oldLabel', this.get( 'label' ) );
            this.set( 'label', this.get( 'processing_label' ) );
			this.trigger( 'reRender' );
		},

		maybeDisable: function( formModel ) {
			this.set( 'disabled', true );
			this.trigger( 'reRender' );
		},

		maybeEnable: function( formModel ) {
			if ( 0 == formModel.get( 'errors' ).models.length ) {
				this.set( 'disabled', false );
				this.trigger( 'reRender' );
			}
		},

		submitFailed: function() {
			this.set( 'label', this.get( 'oldLabel' ) );
			this.trigger( 'reRender' );
		}

	});

	return controller;
} );