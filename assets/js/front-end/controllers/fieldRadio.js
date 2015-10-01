define([], function() {
	var radioChannel = nfRadio.channel( 'radio' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'change:modelValue', this.fieldChange );
			this.listenTo( nfRadio.channel( 'submit' ), 'before:submit', this.test );
		},

		fieldChange: function( model ) {
			if ( 1 == model.get( 'show_other' ) ) {
				model.set( 'reRender', true );
			}
		},

		test: function( formModel ) {
			console.log( 'fired from trigger' );
		}
	});

	return controller;
} );