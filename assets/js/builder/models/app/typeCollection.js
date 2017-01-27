/**
 * Collection that holds our field type models. 
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['models/app/typeModel'], function( typeModel ) {
	var collection = Backbone.Collection.extend( {
		model: typeModel,
		type: false,
		url: nfAdmin.rest_url + 'field-types',

		initialize: function( models, options ) {
			_.each( options, function( option, key ) {
				this[ key ] = option;
			}, this );
		},

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