/**
 * Handles actions related to field settings that use a fieldset
 * 
 * @package Ninja Forms builder
 * @subpackage Fields - Edit Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/views/fields/drawer/typeSettingFieldset','builder/models/fields/typeSettingCollection'], function( fieldsetView, fieldTypeSettingCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fieldset' ).reply( 'get:settingChildView', this.getSettingChildView, this );
			// When a list type field is initialized, create an option collection.
			this.listenTo( nfRadio.channel( 'fields-fieldset' ), 'init:fieldTypeSettingModel', this.createSettingsCollection );
		},
		/**
		 * Return our 
		 * @since  version
		 * @param  {[type]} model [description]
		 * @return {[type]}       [description]
		 */
		getSettingChildView: function( model ) {
			return fieldsetView;
		},

		/**
		 * Instantiate settings collection when a fieldset type is initialized.
		 * 
		 * @since  3.0
		 * @param  backbone.model 	model 	field model being initialized
		 * @return void
		 */
		createSettingsCollection: function( model ) {
			model.set( 'settings', new fieldTypeSettingCollection( model.get( 'settings' ) ) );
		},

	});

	return controller;
} );