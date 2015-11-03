define( [], function() {
	var model = Backbone.Model.extend( {
		initialize: function() {
			this.on( 'change:clean', this.changeStatus, this );
		},

		changeStatus: function() {
			nfRadio.channel( 'app' ).trigger( 'change:clean', this.get( 'clean' ) );
		}
	} );
	
	return model;
} );