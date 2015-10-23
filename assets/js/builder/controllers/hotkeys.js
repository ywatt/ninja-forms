define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:appDomain', this.changeHotkeys );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'add:newField', this.addNewField );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'add:newAction', this.addNewAction );
		},

		changeHotkeys: function( model ) {
			if ( model.get( 'hotkeys' ) ) {
				jQuery.each( model.get( 'hotkeys' ), function( hotkey, msg ) {
					jQuery( document ).off( '.nfDomainHotkeys' );
					jQuery( document ).on( 'keydown.nfDomainHotkeys', null, 'Ctrl+Shift+n', function( e ) {
						nfRadio.channel( 'hotkeys' ).trigger( msg );
					} );
					console.log( 'add filter' );
					jQuery( 'input' ).on( 'keydown.nfDomainHotkeys', null, 'Ctrl+Shift+n', function( e ) {
						nfRadio.channel( 'hotkeys' ).trigger( msg );
					} );
				} );
			}
		},

		addNewField: function() {
			if ( 'addField' != nfRadio.channel( 'app' ).request( 'get:currentDrawer' ) ) {
				nfRadio.channel( 'app' ).request( 'open:drawer', 'addField' );
			} else {
				nfRadio.channel( 'app' ).request( 'close:drawer' );
			}
			
		},

		addNewAction: function() {
			if ( 'addAction' != nfRadio.channel( 'app' ).request( 'get:currentDrawer' ) ) {
				nfRadio.channel( 'app' ).request( 'open:drawer', 'addAction' );
			} else {
				nfRadio.channel( 'app' ).request( 'close:drawer' );
			}
		}

	});

	return controller;
} );