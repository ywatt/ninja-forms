/**
 * Fields settings title view.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var view = Marionette.ItemView.extend({
		tagName: 'div',
		template: '#nf-tmpl-drawer-content-edit-settings-title-fields',

		templateHelpers: function () {
	    	return {
	    		renderTypeNicename: function() {
	    			var currentDomain = nfRadio.channel( 'app' ).request( 'get:currentDomain' );
					var domainID = currentDomain.get( 'id' );
	    			var type = nfRadio.channel( domainID ).request( 'get:type', this.type );
	    			return type.get( 'nicename' );
				},
				
				renderSavedStar: function() {
					if ( this.is_saved ) {
						var star = 'filled';
					} else {
						var star = 'empty';
					}
					return '<span class="dashicons dashicons-star-' + star + '"></span>'
				}
			};
		},
	});

	return view;
} );