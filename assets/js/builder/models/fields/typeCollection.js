/**
 * Collection that holds our field type models. 
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/fields/typeModel'], function( fieldTypeModel ) {
	var collection = Backbone.Collection.extend( {
		model: fieldTypeModel
	} );
	return collection;
} );