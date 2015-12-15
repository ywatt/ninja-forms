define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'listselect' ), 'init:model', this.register );
		},

		register: function( model ) {
			model.set( 'renderOptions', this.renderOptions );
		},

		renderOptions: function() {
			var that = this;
			var html = '';
			_.each( this.options, function( option ) {
				if ( 1 == option.selected ) {
					var selected = true;
				} else {
					var selected = false;
				}

				option.selected = selected;
				option.fieldID = that.id;
				option.classes = that.classes;
				option.currentValue = that.value;
				
				html += _.template( jQuery( '#nf-tmpl-field-listselect-option' ).html(), option );
			} );

			return html;
		}
	});

	return controller;
} );