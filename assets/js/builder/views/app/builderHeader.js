/**
 * Renders our builder header.
 *
 * This is a layout view and handles two regions:
 * app - menu/buttons
 * subapp - title, add new field, etc.
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/views/app/header', 'builder/views/app/subHeader'], function( appHeaderView, appSubHeaderView ) {

	var view = Marionette.LayoutView.extend({
		tagName: "div",
		template: "#nf-tmpl-header",

		regions: {
			app: "#nf-app-header",
			appSub: "#nf-app-sub-header"
		},

		initialize: function() {
			this.listenTo( nfRadio.channel( 'app' ), 'change:currentDomain', this.changeSubHeader );
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
	    			var formData = nfRadio.channel( 'app' ).request( 'get:formData' );
	    			return formData.get( 'settings' ).title;
				},
			};
		},
	});

	return view;
} );