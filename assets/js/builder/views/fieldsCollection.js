define( ['lib/backbone.radio'], function( Radio ) {

	var FieldsView = Marionette.ItemView.extend({
	  template: "#tmpl-nf-fields",

	  events: {
	  	'click .test': 'editField'
	  },

	  editField: function() {
	  	Radio.channel( 'fields' ).trigger( 'editField:editField' );
	  },

	  onShow: function() {
	  	
	  },

	});

	return FieldsView;
} );