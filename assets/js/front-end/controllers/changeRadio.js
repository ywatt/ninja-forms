define(['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'radio' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'change:modelValue', this.fieldChange );
		},

		fieldChange: function( model ) {
			if ( 1 == model.get( 'show_other' ) ) {
				model.set( 'reRender', true );
			}
		}
	});

	return controller;
} );