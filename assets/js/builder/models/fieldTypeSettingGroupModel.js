define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			display: false,

			renderLabel: function() {
				if ( '' != this.label ) {
					this.arrowDir = 'down';
					return _.template( jQuery( '#nf-tmpl-drawer-content-edit-field-setting-group-label' ).html(), this );
				} else {
					return '';
				}
			},

			renderArrowDir: function() {
				if ( this.display ) {
					return 'up';
				} else {
					return 'down';
				}
			}
		}
	} );
	
	return model;
} );