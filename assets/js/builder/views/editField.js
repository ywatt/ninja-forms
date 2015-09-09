define( ['lib/backbone.radio'], function( Radio ) {

	var EditFieldView = Marionette.ItemView.extend({
	  template: "#tmpl-nf-edit-field",

	  events: {
	  	'click .save-field-settings': 'saveField'
	  },

	  saveField: function() {
	  	Radio.channel( 'fields' ).trigger( 'saveField:saveField' );
	  },

	  onShow: function() {
	  	
	  },

	});

	return EditFieldView;
} );