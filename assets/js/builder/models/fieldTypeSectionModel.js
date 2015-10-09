define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			classes: '',
			renderFieldTypes: function() {
		        var html = '';
		        _.each( this.fieldTypes, function( id ) {
		            var type = nfRadio.channel( 'data' ).request( 'get:fieldType', id );
		            var nicename = type.get( 'nicename' );
		            html += _.template( jQuery( '#nf-tmpl-drawer-field-type-button' ).html(), { id: id, nicename: nicename } );
		        } );
		        return html;
			}
		}
	} );
	
	return model;
} );