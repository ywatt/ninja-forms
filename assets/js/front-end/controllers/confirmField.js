define( ['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'fields' );
	var errorID = 'confirm-mismatch';
	var errorMsg = 'These fields must match!';

	var controller = Marionette.Object.extend( {

		initialize: function() {
			this.listenTo( radioChannel, 'init:model', this.registerConfirm );
			this.listenTo( radioChannel, 'keyup:field', this.confirmKeyup );
		},

		registerConfirm: function( confirmModel ) {
			if ( confirmModel.get( 'confirm_field' ) ) {
				var targetModel = radioChannel.request( 'get:field', confirmModel.get( 'confirm_field' ) );
				targetModel.set( 'confirm_with', confirmModel.get( 'id' ) );
				var targetID = targetModel.get( 'id' );
				var confirmID = confirmModel.get( 'id' );

				this.listenTo( Radio.channel( 'field-' + targetID ), 'change:modelValue', this.changeValue );
				this.listenTo( Radio.channel( 'field-' + confirmID ), 'change:modelValue', this.changeValue );
			}
		},

		changeValue: function( model ) {
			if ( 'undefined' == typeof model.get( 'confirm_with' ) ) {
				var confirmModel = model;
				var targetModel = radioChannel.request( 'get:field', confirmModel.get( 'confirm_field' ) );
			} else {
				var targetModel = model;
				var confirmModel = radioChannel.request( 'get:field', targetModel.get( 'confirm_with' ) );
			}
			var targetID = targetModel.get( 'id' );
			var confirmID = confirmModel.get( 'id' );

			if ( '' == confirmModel.get( 'value' ) || confirmModel.get( 'value' ) == targetModel.get( 'value' ) ) {
				Radio.channel( 'fields' ).request( 'remove:error', confirmID, errorID );
			} else {
				Radio.channel( 'fields' ).request( 'add:error', confirmID, errorID, errorMsg );
			}
		},

		
		confirmKeyup: function( el, keyCode, model ) {
			var currentValue = jQuery( el ).val();
			if ( model.get( 'confirm_field' ) ) {
				var confirmModel = model;
				var confirmID = model.get( 'id' );
				var targetModel = Radio.channel( 'fields' ).request( 'get:field', confirmModel.get( 'confirm_field' ) );
				var compareValue = targetModel.get( 'value' );
				var confirmValue = currentValue;
			} else if ( model.get( 'confirm_with' ) ) {
				var confirmModel = Radio.channel( 'fields' ).request( 'get:field', model.get( 'confirm_with' ) );
				var confirmID = confirmModel.get( 'id' );
				var confirmValue = confirmModel.get( 'value' );
				var compareValue = confirmValue;
			}

			if ( 'undefined' !== typeof confirmModel ) {
				if ( '' == confirmValue ) {
					confirmModel.removeWrapperClass( 'nf-fail' );
					confirmModel.removeWrapperClass( 'nf-pass' );
					Radio.channel( 'fields' ).request( 'remove:error', confirmID, errorID );				
				} else if ( currentValue == compareValue ) {
					confirmModel.removeWrapperClass( 'nf-fail' );
					confirmModel.addWrapperClass( 'nf-pass' );
					Radio.channel( 'fields' ).request( 'remove:error', confirmID, errorID );				
				} else {
					confirmModel.removeWrapperClass( 'nf-pass' );
					confirmModel.addWrapperClass( 'nf-fail' );
					Radio.channel( 'fields' ).request( 'add:error', confirmID, errorID, errorMsg );				
				}				
			}
		}
	});

	return controller;
} );