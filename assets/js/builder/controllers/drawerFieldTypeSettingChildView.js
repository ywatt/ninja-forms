define( ['builder/views/drawerFieldTypeSetting'], function( fieldTypeSettingView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fields' ).reply( 'get:settingChildView', this.getSettingChildView, this );
		},

		getSettingChildView: function( model ) {
			var type = model.get( 'type' );
			var settingChildView = nfRadio.channel( type ).request( 'get:settingChildView', model ) || fieldTypeSettingView;
			
			return settingChildView
		}

	});

	return controller;
} );