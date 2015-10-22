define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			getFieldID: function() {
				if ( jQuery.isNumeric( this.id ) ) {
					return 'field-' + this.id;
				} else {
					return this.id;
				}
			}
		}
	} );
	
	return model;
} );