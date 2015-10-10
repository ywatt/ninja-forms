define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			classes: '',
			savedField: false
		}
	} );
	
	return model;
} );