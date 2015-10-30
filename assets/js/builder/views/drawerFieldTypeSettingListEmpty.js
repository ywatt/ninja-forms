define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'tr',
		template: '#nf-tmpl-edit-field-setting-list-empty'
	});

	return view;
} );