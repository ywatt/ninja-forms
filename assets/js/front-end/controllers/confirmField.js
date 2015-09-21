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

		confirmKeyup: function( el, keyCode, model ) {

			if ( model.get( 'confirm_field' ) ) {
				var targetModel = Radio.channel( 'fields' ).request( 'get:field', this.targetID );
				var currentValue = jQuery( el ).val();
				if ( '' == currentValue ) {
					model.removeWrapperClass( 'nf-fail' );
					model.removeWrapperClass( 'nf-pass' );
				} else if ( currentValue == targetModel.get( 'value' ) ) {
					model.removeWrapperClass( 'nf-fail' );
					model.addWrapperClass( 'nf-pass' );
				} else {
					model.removeWrapperClass( 'nf-pass' );
					model.addWrapperClass( 'nf-fail' );
				}
			} else if ( model.get( 'id' ) == this.targetID ) {
				var listeningModel = Radio.channel( 'fields' ).request( 'get:field', this.listeningID );
				var targetValue = jQuery( el ).val();

				if ( '' == targetValue ) {
					listeningModel.removeWrapperClass( 'nf-fail' );
					listeningModel.removeWrapperClass( 'nf-pass' );
				} else if ( targetValue == listeningModel.get( 'value' ) ) {
					listeningModel.removeWrapperClass( 'nf-fail' );
					listeningModel.addWrapperClass( 'nf-pass' );
				} else {
					listeningModel.removeWrapperClass( 'nf-pass' );
					listeningModel.addWrapperClass( 'nf-fail' );
				}
			}
		}

	});

	return controller;
} );