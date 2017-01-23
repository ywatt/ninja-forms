/**
 * Register a loading blocker, then init and fetch our tutorials collection.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2017 WP Ninjas
 * @since 3.0.25
 */
define( [ 'models/app/tutorialModel', 'models/app/tutorialCollection' ], function( TutorialModel, TutorialCollection) {
	var controller = Marionette.Object.extend( {
		
		/**
		 * Listen for our builder view load and fetch our tutorials after it has loaded.
		 * @since  3.0.25
		 * @return void
		 */
		initialize: function() {
			nfRadio.channel( 'app' ).request( 'add:loadingBlocker', 'tutorials' );
			var tutorialCollection = new TutorialCollection();
			tutorialCollection.fetch( {
				success: function( collection, response, options ) {
						nfRadio.channel( 'app' ).request( 'remove:loadingBlocker', 'tutorials' );
				}
			} );
		}
	});

	return controller;
} );