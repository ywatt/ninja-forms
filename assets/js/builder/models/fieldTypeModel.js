define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			classes: ''
		}
	} );
	
	return model;
} );