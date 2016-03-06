/**
 * When a form is loaded, enable any rtes in textareas.
 */
define([], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'textarea' ), 'render:view', this.initTextareaRTEs );
		},

		initTextareaRTEs: function( view ) {
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
		        'link': 'dashicons dashicons-admin-links',
		        'unlink': 'dashicons dashicons-editor-unlink',
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
		      };
		},

		initTextareaRTEs: function( view ) {
			/*
			 * Custom Button for links
			 */
			var that = this;
			// var linkButton = this.linkButton();
			var linkButton = function( context ) {
				return that.linkButton( context );
			}
			var mediaButton = function( context ) {
				return that.mediaButton( context );
			}
			var mergeTags = this.mergeTags();

			var toolbar = [
				[ 'paragraphStyle', ['style'] ],
				[ 'fontStyle', [ 'bold', 'italic', 'underline','clear' ] ],
				[ 'lists', [ 'ul', 'ol' ] ],
			    [ 'paragraph', [ 'paragraph' ] ],
			    [ 'customGroup', [ 'linkButton', 'unlink' ] ],
			    [ 'table', [ 'table' ] ],
			    [ 'actions', [ 'undo', 'redo' ] ],
			    [ 'tools', [ 'mediaButton', 'mergeTags', 'codeview' ] ]
			];

			jQuery( settingView.el ).find( 'div.setting' ).summernote( {
				toolbar: toolbar,
				buttons: {
					linkButton: linkButton,
					mergeTags: mergeTags,
					mediaButton: mediaButton
				},
				height: 150,   //set editable area's height
				codemirror: { // codemirror options
				    theme: 'monokai',
				    lineNumbers: true
				},
				prettifyHtml: true,
				callbacks: {
					onBlur: function() {
						var name = settingModel.get( 'name' );
						var before = dataModel.get( name );
						var after = jQuery( this ).summernote( 'code' );

						var changes = {
							attr: name,
							before: before,
							after: after
						}

						var label = {
							object: dataModel.get( 'objectType' ),
							label: dataModel.get( 'label' ),
							change: 'Changed ' + settingModel.get( 'label' ) + ' from ' + before + ' to ' + after
						};

						nfRadio.channel( 'changes' ).request( 'register:change', 'changeSetting', dataModel, changes, label );

						dataModel.set( settingModel.get( 'name' ), after );
					}
				}
			} );
		}
	});

	return controller;
} );