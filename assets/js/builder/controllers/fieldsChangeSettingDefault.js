/**
 * Updates our model when the user changes a field setting.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Listen on our fields channel for the change setting event. Fired by the setting view.
			this.listenTo( nfRadio.channel( 'fields' ), 'change:setting', this.changeSetting, this );
		},

		changeSetting: function( e, settingTypeModel, fieldModel ) {
			var name = settingTypeModel.get( 'name' );
			// Sends out a request on the fields-type (fields-text, fields-checkbox, etc) channel to see if that field type needs to return a special value for saving.
			var value = nfRadio.channel( 'fields-' + settingTypeModel.get( 'type' ) ).request( 'before:updateSetting', e, fieldModel, name, settingTypeModel );
			// If we didn't get a special field-type value, get the value from the event passed.
			if ( 'undefined' == typeof value ) {
				value = jQuery( e.target ).val();
			}
			// Update our field model with the new setting value.
			fieldModel.set( name, value );
		}

	});

	return controller;
} );