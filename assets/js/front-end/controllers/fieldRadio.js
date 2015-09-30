define([], function() {
	var radioChannel = nfRadio.channel( 'radio' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'change:modelValue', this.fieldChange );
			this.listenTo( nfRadio.channel( 'form' ), 'before:submit', this.test );
		},

		fieldChange: function( model ) {
			if ( 1 == model.get( 'show_other' ) ) {
				model.set( 'reRender', true );
			}
		},

		test: function( formData, options ) {
			_.each ( formData, function ( field ) {
				if ( field.name == 'nf-field-4' ) {
					field.value = 'plinko!';
				}
				var fieldID = field.name.replace( 'nf-field-', '' );
				fieldModel = nfRadio.channel( 'fields' ).request( 'get:field', fieldID );
			} );
		}
	});

	return controller;
} );