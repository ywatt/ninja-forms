/**
 * Collection that holds our tutorial models. 
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2017 WP Ninjas
 * @since 3.0.25
 */
define( ['models/app/tutorialModel'], function( TutorialModel ) {
	var collection = Backbone.Collection.extend( {
		model: TutorialModel,
		url: nfAdmin.rest_url + 'tutorials',

		/**
		 * Extend Backbone.Collection.sync to add nince and pagination support.
		 *
		 * Set nonce header before every Backbone sync.
		 *
		 * @param {string} method.
		 * @param {Backbone.Model} model.
		 * @param {{success}, *} options.
		 * @returns {*}.
		 */
		sync: function( method, model, options ) {
			var beforeSend;

			options    = options || {};
			beforeSend = options.beforeSend;

			// If we have a localized nonce, pass that along with each sync.
			if ( 'undefined' !== typeof nfAdmin.restNonce ) {
				options.beforeSend = function( xhr ) {
					xhr.setRequestHeader( 'X-WP-Nonce', nfAdmin.restNonce );
				};
			}

			// Continue by calling Bacckbone's sync.
			return Backbone.sync( method, model, options );
		}
	} );
	return collection;
} );