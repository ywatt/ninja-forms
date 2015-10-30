define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			options: false,
			getFieldID: function() {
				if ( jQuery.isNumeric( this.id ) ) {
					return 'field-' + this.id;
				} else {
					return this.id;
				}
			}
		},

		initialize: function() {
			this.bind( 'change', this.changeSetting, this );
			nfRadio.channel( 'data' ).trigger( 'init:fieldModel', this );
			nfRadio.channel( 'field-' + this.get( 'type' ) ).trigger( 'init:fieldModel', this );
		},

		changeSetting: function() {
			if ( ! this.hasChanged( 'isUpdated' ) ) {
				
			}
		}
	} );
	
	return model;
} );