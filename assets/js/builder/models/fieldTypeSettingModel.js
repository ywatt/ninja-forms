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
		}
	} );
	
	return model;
} );