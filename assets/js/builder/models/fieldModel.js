define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			options: false,
			label_pos: 'above',
			getFieldID: function() {
				if ( jQuery.isNumeric( this.id ) ) {
					return 'field-' + this.id;
				} else {
					return this.id;
				}
			}
		},

		initialize: function() {
			var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType', this.get( 'type' ) );
			var parentType = fieldType.get( 'parentType' );
			this.bind( 'change', this.changeSetting, this );
			
			nfRadio.channel( 'fields' ).trigger( 'init:fieldModel', this );
			nfRadio.channel( 'fields-' + parentType ).trigger( 'init:fieldModel', this );
			nfRadio.channel( 'fields-' + this.get( 'type' ) ).trigger( 'init:fieldModel', this );
		},

		changeSetting: function() {
			nfRadio.channel( 'fields' ).trigger( 'update:setting', this );
		}
	} );
	
	return model;
} );