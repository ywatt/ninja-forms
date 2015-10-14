define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			dashicons: '',
			classes: '',
			renderDashicons: function() {
				if ( this.dashicons ) {
					return '<span class="dashicons ' + this.dashicons + '"></span>'
				} else {
					return '';
				}
			}
		}
	} );
	
	return model;
} );