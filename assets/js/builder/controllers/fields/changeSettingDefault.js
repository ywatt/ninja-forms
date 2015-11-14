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

		/**
		 * When we change our field setting, update the model.
		 * 
		 * @since  3.0
		 * @param  Object 			e                event
		 * @param  backbone.model 	settingTypeModel model that holds our field type settings info
		 * @param  backbone.model 	fieldModel       model that holds our field settings
		 * @return void
		 */
		changeSetting: function( e, settingTypeModel, fieldModel ) {
			var name = settingTypeModel.get( 'name' );
			var before = fieldModel.get( name );
			// Sends out a request on the fields-type (fields-text, fields-checkbox, etc) channel to see if that field type needs to return a special value for saving.
			var value = nfRadio.channel( 'fields-' + settingTypeModel.get( 'type' ) ).request( 'before:updateSetting', e, fieldModel, name, settingTypeModel );
			// If we didn't get a special field-type value, get the value from the event passed.
			if ( 'undefined' == typeof value ) {
				value = jQuery( e.target ).val();
			}
			// Update our field model with the new setting value.
			fieldModel.set( name, value );
			// Register our setting change with our change tracker
			var after = value;
			
			var changes = {
				attr: name,
				before: before,
				after: after
			}

			var settingModel = nfRadio.channel( 'fields' ).request( 'get:settingModel', name );
			var label = 'Field - ' + fieldModel.get( 'label' ) + ' - ' + settingModel.get( 'label' ) + ' changed from ' + before + ' to ' + after;

			nfRadio.channel( 'changes' ).request( 'register:change', 'changeSetting', fieldModel, changes, label );
		}

	});

	return controller;
} );