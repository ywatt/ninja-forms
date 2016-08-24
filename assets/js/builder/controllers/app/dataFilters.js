/**
 * Run any data filters we need after data has loaded.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2016 WP Ninjas
 * @since 3.0
 */
define( ['models/app/appModel'], function( appModel ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.filterFormContentData();
		},

		filterFormContentData: function() {
			var formContentData = nfRadio.channel( 'settings' ).request( 'get:setting', 'formContentData' );

			/*
			 * As of version 3.0, 'fieldContentsData' has deprecated in favour of 'formContentData'.
			 * If we don't have this setting, then we check for this deprecated value.
			 * 
			 * Set our fieldContentsData to our form setting 'fieldContentsData'
			 *
			 * TODO: Remove this backwards compatibility eventually.
			 */
			if ( ! formContentData ) {
				formContentData = nfRadio.channel( 'settings' ).request( 'get:setting', 'fieldContentsData' );
			}
			
			/*
			 * If we don't have a filter for our formContentData, default to fieldCollection.
			 */
			var formContentLoadFilters = nfRadio.channel( 'formContent' ).request( 'get:loadFilters' );
			
			/* 
			* Get our first filter, this will be the one with the highest priority.
			*/
			var sortedArray = _.without( formContentLoadFilters, undefined );
			var callback = _.first( sortedArray );
			formContentData = callback( formContentData );

			nfRadio.channel( 'settings' ).request( 'update:setting', 'formContentData', formContentData, true );
		}
	});

	return controller;
} );