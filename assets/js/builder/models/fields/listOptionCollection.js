/**
 * Model that represents our list options.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/models/fields/listOptionModel'], function( listOptionModel ) {
	var collection = Backbone.Collection.extend( {
		model: listOptionModel,
		comparator: 'order',

		initialize: function() {
			// Listen to the 'sort' event
			this.on( 'sort', this.changeCollection, this );
		},

		changeCollection: function() {
			// Trigger a 'sort:options' event so that our field model can update
			nfRadio.channel( 'list-repeater' ).trigger( 'sort:options', this );
		}
	} );
	return collection;
} );