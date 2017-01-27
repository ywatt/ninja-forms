/**
 * Model for our app data.
 * Listens for changes to the 'clean' attribute and triggers a radio message when the state changes.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var model = Backbone.Model.extend( {
		defaults: {
			loading: false,
			loadingBlockers: {}
		},

		initialize: function() {
			/*
			 * Set the mobile setting used to track whether or not we're on a mobile device.
			 */
			var mobile = ( 1 == nfAdmin.mobile ) ? true : false;
			this.set( 'mobile', mobile );

			/*
			 * Listen to changes to our 'clean' attribute.
			 */ 
			this.on( 'change:clean', this.changeStatus, this );

			/*
			 * Respond to requests to see if we are on mobile.
			 */
			nfRadio.channel( 'app' ).reply( 'is:mobile', this.isMobile, this );

			/*
			 * Respond to app channel requests for information about the state of our app.
			 */
			nfRadio.channel( 'app' ).reply( 'get:data', this.getData, this );
			nfRadio.channel( 'app' ).reply( 'get:setting', this.getSetting, this );
			nfRadio.channel( 'app' ).reply( 'get:currentDomain', this.getCurrentDomain, this );
			nfRadio.channel( 'app' ).reply( 'get:currentDrawer', this.getCurrentDrawer, this );
			nfRadio.channel( 'drawer' ).reply( 'get:current', this.getCurrentDrawer, this );

			/*
			 * Respond to app channel requests to update app settings.
			 */		
			nfRadio.channel( 'app' ).reply( 'update:currentDomain', this.updateCurrentDomain, this );
			nfRadio.channel( 'app' ).reply( 'update:currentDrawer', this.updateCurrentDrawer, this );
			nfRadio.channel( 'app' ).reply( 'update:setting', this.updateSetting, this );
		},

		changeStatus: function() {
			// Send out a radio message when the 'clean' attribute changes.
			nfRadio.channel( 'app' ).trigger( 'change:clean', this.get( 'clean' ) );
		},

		isMobile: function() {
			return this.get( 'mobile' );
		},

		updateCurrentDomain: function( model ) {
			this.updateSetting( 'currentDomain', model );
		},

		updateSetting: function( setting, value ) {
			this.set( setting, value );
			return true;
		},

		getSetting: function( setting ) {
			return this.get( setting );
		},

		getData: function() {
			return this;
		},

		getCurrentDomain: function() {
			return this.get( 'currentDomain' );
		},

		updateCurrentDrawer: function( drawerID ) {
			this.updateSetting( 'currentDrawer', drawerID );
			return true;
		},

		getCurrentDrawer: function() {
			var currentDrawerID = this.get( 'currentDrawer' );
			return nfRadio.channel( 'app' ).request( 'get:drawer', currentDrawerID );
		}
	} );
	
	return model;
} );