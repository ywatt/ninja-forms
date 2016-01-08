/**
 * Handles actions related to settings that utilise the Rich Text Editor
 * 
 * @package Ninja Forms builder
 * @subpackage App - Settings Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// We don't want the RTE setting to re-render when the value changes.
			nfRadio.channel( 'setting-type-rte' ).reply( 'renderOnChange', function(){ return false } );

			// When an RTE setting is shown, re-render RTE.
			this.listenTo( nfRadio.channel( 'setting-type-rte' ), 'render:setting', this.renderSetting );

			// When an RTE setting view is destroyed, remove our RTE.
			this.listenTo( nfRadio.channel( 'setting-type-rte' ), 'destroy:setting', this.destroySetting );

			// When our drawer opens, re-render any RTEs we have.
			// this.listenTo( nfRadio.channel( 'setting-type-rte' ), 'drawer:opened', this.drawerOpened );
		},

		initRTE: function( settingModel, dataModel, settingView ) {
			jQuery( settingView.el ).find( 'div.setting' ).summernote();
		},

		renderSetting: function( settingModel, dataModel, settingView ) {
			this.initRTE( settingModel, dataModel,settingView );
		},

		destroySetting: function( settingModel, dataModel, settingView ) {
			this.removeRTE( settingModel, dataModel, settingView );
		},

		removeRTE: function( settingModel, dataModel, settingView ) {
			jQuery( settingView.el ).find( 'div.setting' ).summernote( 'destroy' );
		},

		drawerOpened: function( settingModel, dataModel, settingView ) {
			this.initRTE( settingModel, dataModel, settingView );
		}

	});

	return controller;
} );