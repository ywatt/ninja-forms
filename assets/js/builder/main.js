require.config( {
	baseUrl: nfAdmin.requireBaseUrl
} );

require( ['lib/backbone.radio', 'builder/views/mainLayout', 'builder/controllers/editField', 'builder/controllers/saveField', 'builder/controllers/closeAddFields'], function( Radio, mainLayout, fieldController ) {
	// Load our main view
	var mainLayout = new mainLayout();

} );