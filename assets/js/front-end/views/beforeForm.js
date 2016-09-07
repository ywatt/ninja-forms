define( [], function( ) {

	var view = Marionette.ItemView.extend({
		tagName: "nf-section",
		template: "#tmpl-nf-before-form",

		templateHelpers: function () {
			return {

				renderFieldsMarkedRequired: function() {
					var requiredFields = _.filter( this.fields.models, function( field ) { return field.get( 'required' ) } );
					return ( requiredFields.length ) ? nfi18n.fieldsMarkedRequired : '';
				},
			};
		},

	});

	return view;
} );