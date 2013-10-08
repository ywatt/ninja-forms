var ds = ds || {};

/**
 * Demo 5
 */
( function( $ ) {
	var media;

	ds.media = media = {};

	_.extend( media, { view: {}, controller: {} } );

	media.view.basicSettings = wp.media.View.extend( {
		className: 'basic-settings-frame',
		template:  wp.media.template( 'basic-settings' ) // <script type="text/html" id="tmpl-basic-settings">
	} );

	media.controller.basicSettings = wp.media.controller.State.extend( {
		defaults: {
			id:       'basic-settings-state',
			menu:     'default',
			content:  'basic_settings_state'
		}
	} );	

	media.view.emailSettings = wp.media.View.extend( {
		className: 'email-settings-frame',
		template:  wp.media.template( 'email-settings' ) // <script type="text/html" id="tmpl-email-settings">
	} );

	media.controller.emailSettings = wp.media.controller.State.extend( {
		defaults: {
			id:       'email-settings-state',
			menu:     'default',
			content:  'email_settings_state'
		}
	} );

	media.view.conditionalSettings = wp.media.View.extend( {
		className: 'conditional-settings-frame',
		template:  wp.media.template( 'conditional-settings' ) // <script type="text/html" id="tmpl-email-settings">
	} );

	media.controller.conditionalSettings = wp.media.controller.State.extend( {
		defaults: {
			id:       'conditional-settings-state',
			menu:     'default',
			content:  'conditional_settings_state'
		}
	} );

	media.buttonId = '#open-media-modal',

	_.extend( media, {
		frame: function() {
			if ( this._frame )
				return this._frame;


			var states = [

				new media.controller.basicSettings( {
					title:    'Basic Settings',
					id:       'basic-settings-state',
					priority: 10
				} ),				

				new media.controller.emailSettings( {
					title:    'Email Settings',
					id:       'email-settings-state',
					priority: 15
				} ),				

				new media.controller.conditionalSettings( {
					title:    'Conditional Logic',
					id:       'conditional-settings-state',
					priority: 20
				} ),				
			];

			this._frame = wp.media( {
				className: 'media-frame no-sidebar',
				states: states,
				frame: 'post'
			} );

			this._frame.on( 'content:create:basic_settings_state', function() {
				var view = new ds.media.view.basicSettings( {
					controller: media.frame(),
					model:      media.frame().state()
				} );

				media.frame().content.set( view );
			} );			

			this._frame.on( 'content:create:email_settings_state', function() {
				var view = new ds.media.view.emailSettings( {
					controller: media.frame(),
					model:      media.frame().state()
				} );

				media.frame().content.set( view );
			} );

			this._frame.on( 'content:create:conditional_settings_state', function() {
				var view = new ds.media.view.conditionalSettings( {
					controller: media.frame(),
					model:      media.frame().state()
				} );

				media.frame().content.set( view );
			} );

			this._frame.on( 'open', this.open );

			this._frame.on( 'ready', this.ready );

			this._frame.on( 'close', this.close );

			this._frame.on( 'menu:render:default', this.menuRender );

			this._frame.setState('basic-settings-state');

			return this._frame;
		},

		open: function() {
			$( '.media-modal' ).addClass( 'smaller' );
		},

		ready: function() {
			console.log( 'Frame ready' );
		},

		close: function() {
			$( '.media-modal' ).removeClass( 'smaller' );
		},

		menuRender: function( view ) {
			view.unset( 'gallery' );
			view.unset( 'embed' );		
			view.unset( 'insert' );
			view.unset( 'library-separator' );
			view.set({
				'library-separator2': new wp.media.View({
					className: 'separator',
					priority: 11
				})
			});

		},

		select: function() {
			var settings = wp.media.view.settings,
				selection = this.get( 'selection' );

			$( '.added' ).remove();
			selection.map( media.showAttachmentDetails );
		},

		showAttachmentDetails: function( attachment ) {
			var details_tmpl = $( '#attachment-details-tmpl' ),
				details = details_tmpl.clone();

			details.addClass( 'added' );

			$( 'input', details ).each( function() {
				var key = $( this ).attr( 'id' ).replace( 'attachment-', '' );
				$( this ).val( attachment.get( key ) );
			} );

			details.attr( 'id', 'attachment-details-' + attachment.get( 'id' ) );

			var sizes = attachment.get( 'sizes' );
			$( 'img', details ).attr( 'src', sizes.thumbnail.url );

			$( 'textarea', details ).val( JSON.stringify( attachment, null, 2 ) );

			details_tmpl.after( details );
		},

		init: function() {
			$( media.buttonId ).on( 'click', function( e ) {
				e.preventDefault();

				media.frame().open();
			});
		}
	} );

	$( media.init );
} )( jQuery );
