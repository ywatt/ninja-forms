define(['front-end/models/fieldModel'], function( fieldModel ) {
	var radioChannel = nfRadio.channel( 'listradio' );

	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( radioChannel, 'change:modelValue', this.changeModelValue );
			this.listenTo( radioChannel, 'init:model', this.register );
			this.listenTo( radioChannel, 'before:submit', this.beforeSubmit );
		},

		register: function( model ) {
			model.set( 'renderOptions', this.renderOptions );
			model.set( 'renderOtherText', this.renderOtherText );
		},

		changeModelValue: function( model ) {
			if ( 1 == model.get( 'show_other' ) ) {
				model.set( 'reRender', true );
			}
		},

		renderOptions: function() {
			var that = this;
			var html = '';
			_.each( this.options, function( option ) {
				option.fieldID = that.id;
				option.classes = that.classes;
				option.currentValue = that.value;
				
				html += _.template( jQuery( '#nf-tmpl-field-radio-option' ).html(), option );
			} );

			if ( 1 == this.show_other ) {
				var data = {
					fieldID: this.id,
					classes: this.classes,
					currentValue: this.value,
					renderOtherText: this.renderOtherText
				};
				html += _.template( jQuery( '#nf-tmpl-field-radio-other' ).html(), data );

			}

			return html;
		},

		renderOtherText: function() {
			if ( this.currentValue == 'nf-other' ) {
				var data = {
					fieldID: this.id,
					classes: this.classes,
					currentValue: this.value
				};
				return _.template( jQuery( '#nf-tmpl-field-radio-other-text' ).html(), data );
			}
		},

		beforeSubmit: function( model ) {
			if ( 1 == model.get( 'show_other' ) && 'nf-other' == model.get( 'value' ) ) {
				model.set( 'value', 'BLEEP' );
			}
		}
	});

	return controller;
} );