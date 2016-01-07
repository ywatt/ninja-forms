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
			// this.listenTo( nfRadio.channel( 'setting-type-rte' ), 'show:setting', this.showSetting );

			// When an RTE setting view is destroyed, remove our RTE.
			this.listenTo( nfRadio.channel( 'setting-type-rte' ), 'destroy:setting', this.destroySetting );

			// When our drawer opens, re-render any RTEs we have.
			this.listenTo( nfRadio.channel( 'setting-type-rte' ), 'drawer:opened', this.drawerOpened );

			// When our drawer closes, remove our RTE.
			// this.listenTo( nfRadio.channel( 'setting-type-rte' ), 'drawer:closed', this.drawerClosed );
		},

		initRTE: function( settingModel, dataModel, settingView ) {
			var settingName = settingModel.get( 'name' );
			if ( ! tinyMCE.get( settingName ) ) {
				var html = jQuery( settingView.el ).html();
				html = html.replace( /_empty_rte/gi, settingName );
				jQuery( settingView.el ).html( html );
				var rteInit = nfDataTmp.tinyMCEPreInit.replace( /_empty_rte/gi, settingName );
				var tinyMCEInit = JSON.parse( rteInit );
				tinyMCEInit.mceInit[ settingName ].setup = function (editor) {
			        editor.on( 'blur', function () {
			            editor.save();
			            jQuery( editor.targetElm ).trigger( 'change' );
			        });
			    };

				tinymce.init( tinyMCEInit.mceInit[ settingName ] );
				quicktags( tinyMCEInit.qtInit[ settingName ] );
				tinymce.get( settingName ).setContent( dataModel.get( settingName ) );
			}
		},

		showSetting: function( settingModel, dataModel, settingView ) {
			console.log( 'show' );
			this.initRTE( settingModel, dataModel,settingView );
		},

		destroySetting: function( settingModel, dataModel, settingView ) {
			this.removeRTE( settingModel, dataModel, settingView );
		},

		removeRTE: function( settingModel, dataModel, settingView ) {
			tinymce.remove( '#' + settingModel.get( 'name' ) );
		},

		drawerOpened: function( settingModel, dataModel, settingView ) {
			this.initRTE( settingModel, dataModel, settingView );
		},

		drawerClosed: function( settingModel, dataModel, settingView ) {
			this.removeRTE( settingModel, dataModel, settingView );
		}

	});

	return controller;
} );