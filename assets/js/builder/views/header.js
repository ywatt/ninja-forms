define( ['builder/views/appHeader', 'builder/views/appSubHeader'], function( appHeaderView, appSubHeaderView ) {

	var view = Marionette.LayoutView.extend({
		tagName: "div",
		template: "#nf-tmpl-header",

		regions: {
			app: "#nf-app-header",
			appSub: "#nf-app-sub-header"
		},

		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:appDomain', this.changeSubHeader );
		},

		onShow: function() {
			this.app.show( new appHeaderView() );
			this.changeSubHeader();
		},

		changeSubHeader: function() {
			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
			var subHeaderView = currentDomain.get( 'getSubHeaderView' ).call( currentDomain );
			this.appSub.show( subHeaderView );
		},

		templateHelpers: function () {
			var that = this;
	    	return {
	    		renderTitle: function(){
	    			var formData = nfRadio.channel( 'data' ).request( 'get:formData' );
	    			return formData.get( 'settings' ).title;
				},
			};
		},
	});

	return view;
} );