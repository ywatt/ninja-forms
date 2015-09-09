require.config( {
	baseUrl: nfFrontEnd.requireBaseUrl
} );

require( ['builder/controllers/saveField.js'], function(test) {
	console.log( nfFrontEnd.requireBaseUrl );
} );