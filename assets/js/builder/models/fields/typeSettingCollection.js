/**
 * Collections of settings for each field type.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/fields/typeSettingModel'], function( typeSettingModel ) {
	var collection = Backbone.Collection.extend( {
		model: typeSettingModel
	} );
	return collection;
} );