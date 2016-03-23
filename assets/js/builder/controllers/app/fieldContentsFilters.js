/**
 * Before we save data to the database (on preview update or publish), we check to see if we have anyone
 * that wants to update the 'fieldContents' form setting. This setting is used on the front-end to allow
 * for custom display of form fields. i.e. layout rows.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			/*
			 * Init our fieldContents view filter array.
			 */
			this.viewFilters = [];

			/*
			 * Listen for requests to add new fieldContent filters. 
			 */
			nfRadio.channel( 'fieldContents' ).reply( 'add:viewFilter', this.addViewFilter, this );

			/*
			 * Listen for requests to get our fieldContent filters.
			 */
			nfRadio.channel( 'fieldContents' ).reply( 'get:viewFilters', this.getViewFilters, this );
		},

		addViewFilter: function( callback, priority ) {
			this.viewFilters[ priority ] = callback;
		},

		getViewFilters: function() {
			return this.viewFilters;
		}

	});

	return controller;
} );