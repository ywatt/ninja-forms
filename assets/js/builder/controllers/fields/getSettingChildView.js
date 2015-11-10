/**
 * Returns the appropriate child view for our field settings drawer.
 *
 * This enables field types to register custom childviews for their settings.
 * The list-repeater setting for the list types is an example.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - Edit Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/views/fields/drawer/typeSetting'], function( fieldTypeSettingView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Respond to requests for field settings child views.
			nfRadio.channel( 'fields' ).reply( 'get:settingChildView', this.getSettingChildView, this );
		},

		/**
		 * Return the appropriate child setting view.
		 *
		 * @since  3.0
		 * @param  backbone.model	model 	Field setting
		 * @return backbone.view
		 */
		getSettingChildView: function( model ) {
			// Get our setting type.
			var type = model.get( 'type' );
			// Request a setting childview from our setting type channel. (Setting type, not field type)
			var settingChildView = nfRadio.channel( type ).request( 'get:settingChildView', model ) || fieldTypeSettingView;
			
			return settingChildView
		}

	});

	return controller;
} );