define( ['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'fields' );

	var controller = Marionette.Object.extend( {
		listeningModel: '',

		initialize: function() {
			this.listenTo( radioChannel, 'init:model', this.registerMirror );
		},

		registerMirror: function( model ) {
			if ( model.get( 'mirror_field' ) ) {
				this.listeningModel = model;
				var targetID = model.get( 'mirror_field' );
				this.listenTo( Radio.channel( 'field-' + targetID ), 'change:modelValue', this.changeValue );
			}
		},

		changeValue: function( targetModel ) {
			this.listeningModel.set( 'value', targetModel.get( 'value' ) );
			this.listeningModel.set( 'reRender', true );
		}
	});

	return controller;
} );