define( ['builder/views/drawerHeaderDefault'], function( defaultHeaderView ) {
	var model = Backbone.Model.extend( {
		defaults: {
			getHeaderView: function( data ) {
				return new defaultHeaderView( data );
			}
		}
	} );
	
	return model;
} );