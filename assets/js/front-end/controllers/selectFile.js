define(['lib/backbone.radio'], function( Radio ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( Radio.channel( 'file' ), 'init:model', this.initFile );
		},

		initFile: function( model ) {
			this.listenTo( Radio.channel( 'file' ), 'change:field', this.changeFile );
			this.listenTo( Radio.channel( 'fields' ), 'click:field', this.clickFileButton );
		},

		clickFileButton: function( el, model ) {
			if ( jQuery( el ).hasClass( 'nf-file-button' ) ) {
				jQuery( el ).parent().find( 'input[type=file]' ).click();
			} else if ( jQuery( el ).hasClass( 'nf-file-reset' ) ) {
				jQuery( el ).closest( 'form' ).find( 'input[type=file]' ).click();				
			}
		},

		changeFile: function( el, model ) {
			if ( '' == jQuery( el ).val() ) {
				return false;
			}
			var progress = jQuery( el ).parent().find('.nf-file-progress');
			var bar = jQuery( el ).parent().find('.nf-file-bar');
			var percent = jQuery( el ).parent().find('.nf-file-percent');
			var status = jQuery( el ).parent().find('.nf-file-status');
			var button = jQuery( el ).parent().find( '.nf-file-button' );

			var options = {
	            beforeSerialize: function( formData, options ) {
	            	// if ( typeof tinyMCE !== 'undefined' ) {
	            	// 	tinyMCE.triggerSave();
	            	// }
	            },
				beforeSubmit: function( formData, jqForm, options ) {
					console.log( 'before submit' );
				},

				beforeSend: function() {
					status.empty();
					Radio.channel( 'fields' ).trigger( 'disable:submit', model.get( 'formID' ) );
					button.fadeOut( 'fast', function() {
						progress.fadeIn( 'fast', function() {
					        var percentVal = '0%';
					        bar.width(percentVal)
					        percent.html(percentVal);
						} );
					} );
			    },

			    uploadProgress: function(event, position, total, percentComplete) {
			        var percentVal = percentComplete + '%';
			        bar.width(percentVal)
			        percent.html(percentVal);
			    },

			    success: function() {
			        var percentVal = '100%';
			        bar.width(percentVal)
			        percent.html(percentVal);
			    },

				complete: function(xhr) {
					Radio.channel( 'fields' ).trigger( 'enable:submit', model.get( 'formID' ) );
					jQuery( progress ).fadeOut( 'fast', function() {
						var filename = xhr.responseText;
						var link = '<input type="button" class="nf-element nf-file-reset" value="Upload a different file">';
						status.html( link + ' ' + filename );
						status.fadeIn( 'fast' );
					} );
				},

				data: {
					action: 'nf_async_upload'
				}
			};

			jQuery( el ).closest( '.nf-file-form' ).ajaxSubmit( options );
		}
	});

	return controller;
} );