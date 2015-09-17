define( ['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'fields' );

	var controller = Marionette.Object.extend( {

		initialize: function() {
			this.listenTo( radioChannel, 'init:model', this.registerConfirm );
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

		}
	});

	return controller;
} );