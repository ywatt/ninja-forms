define( ['builder/views/fieldsCollection', 'builder/views/editField', 'builder/views/addFields'], function( fieldsView, editFieldView, addFieldsView ) {

	var AppLayoutView = Marionette.LayoutView.extend({
	  el: "#builder",
	  template: "#tmpl-nf-layout",

	  regions: {
	    main: "#nf-main",
	    drawer: "#nf-drawer"
	  },

	  initialize: function() {
	  	this.render();
	  	this.main.show( new fieldsView );
	  	this.drawer.show( new editFieldView );
	  },

	  onShow: function() {
	  	
	  },

	  events: {
	  	
	  },


	});

	return AppLayoutView;
} );