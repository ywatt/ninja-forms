define( ['lib/backbone.radio'], function( Radio ) {

	var view = Marionette.ItemView.extend({
	  template: "#tmpl-nf-add-fields",

	  events: {
	  	'click .close-add-fields': 'closeAddFields'
	  },

	  closeAddFields: function() {
	  	Radio.channel( 'fields' ).trigger( 'closeAddFields:closeAddFields' );
	  },

	  onShow: function() {
	  	
	  },

	});

	return view;
} );