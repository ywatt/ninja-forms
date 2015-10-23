define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			dashicons: '',
			classes: '',
			active: false,
			url: '',
			hotkeys: false,
			
			renderDashicons: function() {
				if ( this.dashicons ) {
					return '<span class="dashicons ' + this.dashicons + '"></span>'
				} else {
					return '';
				}
			},

			renderClasses: function() {
				var classes = this.classes;
				var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
				if ( currentDomain.get( 'id' ) == this.id ) {
					classes += ' active';
				}
				return classes;
			}
		}
	} );
	
	return model;
} );