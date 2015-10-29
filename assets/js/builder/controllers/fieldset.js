define( ['builder/views/drawerFieldTypeSettingFieldset'], function( fieldsetView ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			nfRadio.channel( 'fieldset' ).reply( 'get:settingChildView', this.getSettingChildView, this );
		},

		getSettingChildView: function( model ) {
			return fieldsetView;
		}

	});

	return controller;
} );