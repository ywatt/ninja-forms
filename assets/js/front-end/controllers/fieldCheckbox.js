define([], function() {
	var radioChannel = nfRadio.channel( 'checkbox' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			radioChannel.reply( 'validate:required', this.validateRequired );
            nfRadio.channel( 'checkbox' ).reply( 'before:updateField', this.beforeUpdateField, this );
            nfRadio.channel( 'checkbox' ).reply( 'get:calcValue', this.getCalcValue, this );
			/*
			 * When we render this view, if we have opinionated styles turned on, move the label to after the field.
			 */
			this.listenTo( nfRadio.channel( 'checkbox' ), 'render:view', this.maybeMoveLabel );
		},

		beforeUpdateField: function( el, model ) {
			var checked = jQuery( el ).attr( 'checked' );
			if ( checked ) {
				var value = 1;
				jQuery( el ).addClass( 'nf-checked' );
			} else {
				var value = 0;
				jQuery( el ).removeClass( 'nf-checked' );
			}

			return value;
		},

		validateRequired: function( el, model ) {
			return el[0].checked;
		},

		getCalcValue: function( fieldModel ) {
			if ( 1 == fieldModel.get( 'value' ) ) {
				calcValue = fieldModel.get( 'checked_calc_value' );
			} else {
				calcValue = fieldModel.get( 'unchecked_calc_value' );
			}

			return calcValue;
		},

		maybeMoveLabel: function( view ) {
			if ( nfFrontEnd.opinionated_styles ) {
				/*
				 * Move our label to after the input element.
				 */
				var input = jQuery( view.el ).find( 'input' );
				var label = jQuery( view.el ).find( 'label' );
				input.after( label );
			}
		}
	});

	return controller;
} );