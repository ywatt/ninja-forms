define( ['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'fields' );

	var controller = Marionette.Object.extend( {

		initialize: function() {
			this.listenTo( radioChannel, 'init:model', this.registerConfirm );
			this.listenTo( radioChannel, 'keyup:field', this.confirmKeyup );
		},

		registerConfirm: function( model ) {
			if ( model.get( 'confirm_field' ) ) {
				this.targetID = model.get( 'confirm_field' );
				this.listeningID = model.get( 'id' );

				this.listenTo( Radio.channel( 'field-' + this.targetID ), 'change:modelValue', this.changeValue );
				this.listenTo( Radio.channel( 'field-' + this.listeningID ), 'change:modelValue', this.changeValue );
			}
		},

		changeValue: function( model ) {
			var targetModel = Radio.channel( 'fields' ).request( 'get:field', this.targetID );
			var listeningModel = Radio.channel( 'fields' ).request( 'get:field', this.listeningID );

			if ( listeningModel.get( 'value' ) != '' ) {
				var errorID = 'confirm-mismatch';
				if ( listeningModel.get( 'value' ) == targetModel.get( 'value' ) ) {
					Radio.channel( 'fields' ).request( 'remove:error', this.listeningID, errorID );
					Radio.channel( 'fields' ).request( 'remove:error', this.targetID, errorID );
				} else {
					var errorMsg = 'These fields must match!';
					Radio.channel( 'fields' ).request( 'add:error', this.listeningID, errorID, errorMsg );
					Radio.channel( 'fields' ).request( 'add:error', this.targetID, errorID, '' );
				}
			}

		},

		confirmKeyup: function( el, model ) {
			if ( model.get( 'confirm_field' ) ) {
				var targetModel = Radio.channel( 'fields' ).request( 'get:field', this.targetID );
				var currentValue = jQuery( el ).val();
				if ( currentValue != '' ) {
					if ( currentValue == targetModel.get( 'value' ) ) {
						jQuery( el ).closest( '.nf-field-wrap' ).removeClass( 'nf-fail' );
						jQuery( el ).closest( '.nf-field-wrap' ).addClass( 'nf-pass' );
					} else {
						jQuery( el ).closest( '.nf-field-wrap' ).removeClass( 'nf-pass' );
						jQuery( el ).closest( '.nf-field-wrap' ).addClass( 'nf-fail' );
					}
				} else {
					jQuery( el ).closest( '.nf-field-wrap' ).removeClass( 'nf-pass' );
					jQuery( el ).closest( '.nf-field-wrap' ).removeClass( 'nf-fail' );
				}
			} else if ( model.get( 'id' ) == this.targetID ) {
				
			}
		}

	});

	return controller;
} );