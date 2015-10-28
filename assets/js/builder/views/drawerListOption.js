define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-edit-field-setting-list-option',

		initialize: function( data ) {
			this.fieldModel = data.fieldModel;
		}

	});

	return view;
} );