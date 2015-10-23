define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'main' ), 'render:main', this.changeHotkeys );

			this.listenTo( nfRadio.channel( 'hotkeys' ), 'add:newField', this.addNewField );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'add:newAction', this.addNewAction );

			this.listenTo( nfRadio.channel( 'hotkeys' ), 'changeDomain:fields', this.changeDomainFields );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'changeDomain:actions', this.changeDomainActions );
			this.listenTo( nfRadio.channel( 'hotkeys' ), 'changeDomain:settings', this.changeDomainSettings );
		},

		changeHotkeys: function() {
			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
			jQuery( document ).off( '.nfDomainHotkeys' );
			jQuery( 'input' ).off( '.nfDomainHotkeys' );
			if ( currentDomain.get( 'hotkeys' ) ) {
				jQuery.each( currentDomain.get( 'hotkeys' ), function( hotkey, msg ) {
					jQuery( document ).on( 'keydown.nfDomainHotkeys', null, hotkey, function( e ) {
						nfRadio.channel( 'hotkeys' ).trigger( msg );
					} );
					jQuery( 'input' ).on( 'keydown.nfDomainHotkeys', null, hotkey, function( e ) {
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
		},

		changeDomainFields: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var fieldDomain = appDomainCollection.get( 'fields' );
			nfRadio.channel( 'app' ).request( 'change:appDomain', fieldDomain );
		},

		changeDomainActions: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var fieldDomain = appDomainCollection.get( 'actions' );
			nfRadio.channel( 'app' ).request( 'change:appDomain', fieldDomain );
		},

		changeDomainSettings: function() {
			var appDomainCollection = nfRadio.channel( 'app' ).request( 'get:appDomainCollection' );
			var fieldDomain = appDomainCollection.get( 'settings' );
			nfRadio.channel( 'app' ).request( 'change:appDomain', fieldDomain );
		}

	});

	return controller;
} );