define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',

		initialize: function() {
			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
			this.template = '#' + currentDomain.get( 'templateID' );
		}
	});

	return view;
} );