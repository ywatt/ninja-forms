define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			settings: false,
			placeholder: '',
			renderLabel: function() {
				if ( 'undefined' != typeof this.label ) {
					return '<label>' + this.label + '</label>';
				} else {
					return '';
				}
			},
			renderWidth: function() {
				if ( 'undefined' != typeof this.width ) {
					return this.width;
				} else {
					return 'one-half';
				}
			}
		},

		initialize: function() {
			nfRadio.channel( 'fields' ).trigger( 'init:fieldTypeModel', this );
			nfRadio.channel( 'fields-' + this.get( 'type' ) ).trigger( 'init:fieldTypeModel', this );
		}
	} );
	
	return model;
} );