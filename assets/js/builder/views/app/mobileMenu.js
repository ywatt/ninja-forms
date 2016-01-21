/**
 * Single item view used for the menu drawer.
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['views/app/mobileMenuItem'], function( mobileMenuItemView ) {
	var view = Marionette.CompositeView.extend({
		tagName: 'div',
		template: '#nf-tmpl-mobile-menu',
		childView: mobileMenuItemView,

		attachHtml: function( collectionView, childView ) {
			jQuery( collectionView.el ).find( '.secondary' ).append( childView.el );
		}
	});

	return view;
} );