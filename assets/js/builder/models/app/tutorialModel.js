/**
 * Model for our tutorial
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2017 WP Ninjas
 * @since 3.0.25
 */
define( [], function() {
	var model = Backbone.Model.extend( {
		modal: false,

		initialize: function() {
			/*
			 * Trigger a radio message saying that our tutorial model has been initialised.
			 */
			nfRadio.channel( 'tutorials' ).trigger( 'init:model', this );

			/*
			 * Add a listener for our tutorial trigger
			 */
			this.listenTo( nfRadio.channel( 'tutorials' ), this.get( 'trigger' ), this.showModal );

			/*
			 * Init our modal
			 */
			var templateData = {
				description: this.get( 'description' ),
				videoUrl: this.get( 'video_url' )
			}

			var template = nfRadio.channel( 'app' ).request( 'get:template',  '#tmpl-nf-tutorial-content' )
			var content = template( templateData );
			var that = this;
			this.modal = new jBox('Modal', {
				title: this.get( 'title' ),
				content: content,
				zIndex: 99999999,
				closeButton: 'box',
				onClose: function() {
					that.closeModal();
				}
			});
		},

		showModal: function() {
			this.modal.open();
		},

		closeModal: function() {
			console.log( 'close Modal' );
			// this.set( 'closed', true );
			// this.save();
		}
	} );
	
	return model;
} );