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

			// Instantiates the variable that holds the media library frame.
			this.meta_image_frame;
		},

		initRTE: function( settingModel, dataModel, settingView ) {
			/*
			 * Custom Button for links
			 */
			var linkButton = this.linkButton();
			var mergeTags = this.mergeTags();
			var mediaButton = this.mediaButton();

			var toolbar = [
				[ 'paragraphStyle', ['style'] ],
				[ 'bold', [ 'bold' ] ],
				[ 'italic', [ 'italic' ] ],
				[ 'underline', [ 'underline' ] ],
				[ 'clear', ['clear' ] ],
			    [ 'ul', [ 'ul' ] ],
			    [ 'ol', [ 'ol' ] ],
			    [ 'paragraph', [ 'paragraph' ] ],
			    [ 'color', [ 'color' ] ],
			    [ 'codeview', [ 'codeview' ] ],
			    [ 'customGroup', [ 'linkButton' ] ],
			    [ 'mergeTags', [ 'mergeTags' ] ],
			    [ 'mediaButton', [ 'mediaButton' ] ]
			];

			jQuery( settingView.el ).find( 'div.setting' ).summernote( {
				toolbar: toolbar,
				buttons: {
					linkButton: linkButton,
					mergeTags: mergeTags,
					mediaButton: mediaButton
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
			var linkButton = _.template( jQuery( '#nf-tmpl-rte-link-button' ).html(), {} );
			var linkDropdown = _.template( jQuery( '#nf-tmpl-rte-link-dropdown' ).html(), {} );
			return ui.buttonGroup([
				ui.button({
	            className: 'dropdown-toggle',
	            contents: linkButton,
	            tooltip: 'Insert Link',
	            data: {
	              toggle: 'dropdown'
	            }
	          }),
				ui.dropdown([
	            ui.buttonGroup({
	              children: [
	                ui.button({
	                  contents: linkDropdown,
	                  tooltip: '',
	                  click: ''
	                }),
	              ]
	            })
	          ])
			]).render();
		},

		mergeTags: function( context ) {
			var ui = jQuery.summernote.ui;
			var mergeTagsButton = _.template( jQuery( '#nf-tmpl-rte-merge-tags-button' ).html(), {} );
			return ui.button({
	            className: 'dropdown-toggle',
	            contents: mergeTagsButton,
	            tooltip: 'Merge Tags'
	          }).render();
		},

		mediaButton: function( context ) {
			var ui = jQuery.summernote.ui;
			var mediaButton = _.template( jQuery( '#nf-tmpl-rte-media-button' ).html(), {} );
			return ui.button({
	            className: 'dropdown-toggle',
	            contents: mediaButton,
	            tooltip: 'Insert Media',
	            click: this.coolTestFunction
	          }).render();
		},

		coolTestFunction: function() {
			// If the frame already exists, re-open it.
			if ( this.meta_image_frame ) {
				this.meta_image_frame.open();
				return;
			}

			// Sets up the media library frame
			this.meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
				title: 'Select a file',
				button: { text:  'insert' }
			});

			var that = this;

			// Runs when an image is selected.
			this.meta_image_frame.on('select', function(){

				// Grabs the attachment selection and creates a JSON representation of the model.
				var media_attachment = that.meta_image_frame.state().get('selection').first().toJSON();
				console.log( media_attachment );
			});

			// Opens the media library frame.
			this.meta_image_frame.open();
		}
	});

	return controller;
} );