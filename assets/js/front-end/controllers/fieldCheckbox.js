define([], function() {
	var radioChannel = nfRadio.channel( 'checkbox' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			/*
			 * When we init our checkbox model, register our renderClasses() function
			 */
			this.listenTo( nfRadio.channel( 'checkbox' ), 'init:model', this.registerRenderClasses );

			radioChannel.reply( 'validate:required', this.validateRequired );
            nfRadio.channel( 'checkbox' ).reply( 'before:updateField', this.beforeUpdateField, this );
            nfRadio.channel( 'checkbox' ).reply( 'get:calcValue', this.getCalcValue, this );
		},

		beforeUpdateField: function( el, model ) {
			var checked = jQuery( el ).attr( 'checked' );
			if ( checked ) {
				var value = 1;
				jQuery( el ).addClass( 'nf-checked' );
				jQuery( el ).closest( '.field-wrap' ).find( 'label[for="' + jQuery( el ).prop( 'id' ) + '"]' ).addClass( 'nf-checked-label' );
			} else {
				var value = 0;
				jQuery( el ).removeClass( 'nf-checked' );
				jQuery( el ).closest( '.field-wrap' ).find( 'label[for="' + jQuery( el ).prop( 'id' ) + '"]' ).removeClass( 'nf-checked-label' );
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

		registerRenderClasses: function( model ) {
			model.set( 'renderClasses', this.renderClasses );
			model.set( 'customLabelClasses', this.customLabelClasses );
			model.set( 'maybeChecked', this.maybeChecked );
		},

		renderClasses: function() {
			this.setClasses();
			if ( 'undefined' != typeof this.default_value && 'checked' == this.default_value ) {
				this.classes += ' nf-checked';
			} else {
				this.classes.replace( 'nf-checked', '' );
			}
			return this.classes;
		},

		customLabelClasses: function( classes ) {
			if ( 'undefined' != typeof this.default_value && 'checked' == this.default_value ) {
				classes += ' nf-checked-label';
			} else {
				classes.replace( 'nf-checked-label', '' );
			}
			return classes;
		},

		maybeChecked: function() {
			if( 'undefined' != typeof this.default_value && 'checked' == this.default_value ) {
				return ' checked';
			} else {
				return '';
			}
		}
	});

	return controller;
} );