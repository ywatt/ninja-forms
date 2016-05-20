define( ['views/formErrorCollection'], function( FormErrors ) {

    var view = Marionette.LayoutView.extend({
        tagName: "nf-section",
        template: "#nf-tmpl-after-fields",

		regions: {
			errors: ".nf-form-errors"
		},

        onShow: function() {
        	this.errors.show( new FormErrors( { collection: this.model.get( 'errors' ) } ) );
        }

    });

    return view;
} );