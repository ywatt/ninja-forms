define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-content-edit-field',

		initialize: function() {
			var fieldType = nfRadio.channel( 'data' ).request( 'get:fieldType' , this.model.get( 'type' ) );
			console.log( fieldType );
		}
	});

	return view;
} );