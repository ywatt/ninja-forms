define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			classes: '',
			renderFieldTypes: function() {
		        var html = '';
		        var that = this;
		        _.each( this.fieldTypes, function( id ) {
		            var type = nfRadio.channel( 'data' ).request( 'get:fieldType', id );
		            var nicename = type.get( 'nicename' );
		            html += _.template( jQuery( '#nf-tmpl-drawer-field-type-button' ).html(), { id: id, nicename: nicename, type: type, savedField: that.isSavedField } );
		        } );
		        return html;
			},
			isSavedField: function() {
				if( this.type.get( 'savedField' ) ) {
					return 'nf-saved';
				} else {
					return '';
				}
			}
		}
	} );
	
	return model;
} );