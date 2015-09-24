define(['lib/backbone.radio'], function( Radio ) {
	var radioChannel = Radio.channel( 'radio' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'change:modelValue', this.fieldChange );
			this.listenTo( Radio.channel( 'form' ), 'before:submit', this.test );
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
				fieldModel = Radio.channel( 'fields' ).request( 'get:field', fieldID );
			} );
		}
	});

	return controller;
} );