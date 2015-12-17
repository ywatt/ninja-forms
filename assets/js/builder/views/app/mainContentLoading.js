define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
        className: 'nf-domain-loading',
		template: '#nf-tmpl-main-content-loading'
	});

	return view;
} );
