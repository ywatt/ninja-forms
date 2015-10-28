define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'drawer' ), 'click:toggleSettingGroup', this.toggleSettingGroup );
		},

		toggleSettingGroup: function( e, model ) {
			if ( model.get( 'display' ) ) {
				model.set( 'display', false );
			} else {
				model.set( 'display', true );
			}
		}

	});

	return controller;
} );