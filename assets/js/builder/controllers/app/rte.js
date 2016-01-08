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

			jQuery.summernote.options.icons = {
		        'align': 'dashicons dashicons-editor-alignleft',
		        'alignCenter': 'dashicons dashicons-editor-aligncenter',
		        'alignJustify': 'dashicons dashicons-editor-justify',
		        'alignLeft': 'dashicons dashicons-editor-alignleft',
		        'alignRight': 'dashicons dashicons-editor-alignright',
		        'indent': 'dashicons dashicons-editor-indent',
		        'outdent': 'dashicons dashicons-editor-outdent',
		        // 'arrowsAlt': 'dashicons fa-arrows-alt',
		        'bold': 'dashicons dashicons-editor-bold',
		        'caret': 'dashicons dashicons-arrow-down',
		        // 'circle': 'dashicons fa-circle',
		        'close': 'dashicons dashicons-dismiss',
		        'code': 'dashicons dashicons-editor-code',
		        'eraser': 'dashicons dashicons-editor-removeformatting',
		        // 'font': 'dashicons fa-font',
		        // 'frame': 'dashicons fa-frame',
		        'italic': 'dashicons dashicons-editor-italic',
		        // 'link': 'dashicons fa-link',
		        // 'unlink': 'dashicons fa-chain-broken',
		        'magic': 'dashicons dashicons-editor-paragraph',
		        // 'menuCheck': 'dashicons fa-check',
		        'minus': 'dashicons dashicons-minus',
		        'orderedlist': 'dashicons dashicons-editor-ol',
		        // 'pencil': 'dashicons fa-pencil',
		        // 'picture': 'dashicons fa-picture-o',
		        // 'question': 'dashicons fa-question',
		        'redo': 'dashicons dashicons-redo',
		        'square': 'dashicons fa-square',
		        // 'strikethrough': 'dashicons fa-strikethrough',
		        // 'subscript': 'dashicons fa-subscript',
		        // 'superscript': 'dashicons fa-superscript',
		        'table': 'dashicons dashicons-editor-table',
		        // 'textHeight': 'dashicons fa-text-height',
		        // 'trash': 'dashicons fa-trash',
		        'underline': 'dashicons dashicons-editor-underline',
		        'undo': 'dashicons dashicons-undo',
		        'unorderedlist': 'dashicons dashicons-editor-ul',
		        // 'video': 'dashicons fa-youtube-play'
		      }
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
				[ 'fontStyle', [ 'bold', 'italic', 'underline','clear' ] ],
				[ 'lists', [ 'ul', 'ol' ] ],
			    [ 'paragraph', [ 'paragraph' ] ],
			    [ 'customGroup', [ 'linkButton' ] ],
			    [ 'codeview', [ 'codeview' ] ],
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
	            click: this.openMediaManager
	          }).render();
		},

		openMediaManager: function() {
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