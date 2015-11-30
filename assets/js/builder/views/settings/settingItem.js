define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-form-setting-type',

		events: {
			'click': 'clickEdit'
		},

		clickEdit: function( e ) {
			var model = nfRadio.channel( 'settings' ).request( 'get:settings' );
			nfRadio.channel( 'app' ).request( 'open:drawer', 'editSettings', { model: model, groupCollection: this.model.get( 'settingGroups' ) } );
		},
	});

	return view;
} );