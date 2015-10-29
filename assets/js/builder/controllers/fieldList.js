define( ['builder/views/drawerFieldTypeSettingListComposite'], function( listCompositeView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'list-repeater' ).reply( 'get:settingChildView', this.getSettingChildView, this );
		},

		getSettingChildView: function( model ) {
			return listCompositeView;
		}

	});

	return controller;
} );