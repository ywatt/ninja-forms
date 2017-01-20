/**
 * Collection that holds our tutorial models. 
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2017 WP Ninjas
 * @since 3.0.25
 */
define( ['models/app/typeModel'], function( typeModel ) {
	var collection = Backbone.Collection.extend( {
		model: typeModel,
		url: nfAdmin.rest_url,

		initialize: function( models, options ) {

		}
	} );
	return collection;
} );