/**
 * Collection of our type settings groups.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/fields/typeSettingGroupModel'], function( typeSettingGroupModel ) {
	var collection = Backbone.Collection.extend( {
		model: typeSettingGroupModel
	} );
	return collection;
} );