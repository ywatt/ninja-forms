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
			/*
			 * Custom Button for links
			 */
			var linkButton = this.linkButton();
			var toolbar = [
				[ 'paragraphStyle', ['style'] ],
				[ 'fontStyle', [ 'bold', 'italic', 'underline', 'clear' ] ],
			    [ 'para', [ 'ul', 'ol', 'paragraph' ] ],
			    [ 'color', [ 'color', 'customLink' ] ],
			    [ 'customGroup', [ 'linkButton' ] ]
			];

			jQuery( settingView.el ).find( 'div.setting' ).summernote( {
				toolbar: toolbar,
				buttons: {
					linkButton: linkButton
				}
			} );
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
		},

		linkButton: function( context ) {
			var ui = jQuery.summernote.ui;
			return ui.buttonGroup([
				ui.button({
	            className: 'dropdown-toggle',
	            contents: '<span class="dashicons dashicons-admin-links"></span>',
	            tooltip: 'Insert Link',
	            data: {
	              toggle: 'dropdown'
	            }
	          }),
				ui.dropdown([
	            ui.buttonGroup({
	              className: 'note-align',
	              children: [
	                ui.button({
	                  contents: '<div style="width:350px" class="summernote-url"><input type="url" style="width:85%"> <input type="button" style="width:15%" value="Insert"></div>',
	                  tooltip: '',
	                  click: ''
	                }),
	              ]
	            })
	          ])
			]).render();
		},
	});

	return controller;
} );