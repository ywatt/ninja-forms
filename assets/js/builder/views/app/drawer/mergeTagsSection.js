/**
 * Merge tags popup section
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['views/app/drawer/mergeTagItem'], function( mergeTagItemView ) {
	var view = Marionette.CompositeView.extend({
		tagName: 'div',
		childView: mergeTagItemView,
		template: '#nf-tmpl-merge-tags-section',

		initialize: function() {
			this.collection = this.model.get( 'tags' );
		},

		attachHtml: function( collectionView, childView ) {
			jQuery( collectionView.el ).find( '.merge-tags' ).append( childView.el );
		}
	});

	return view;
} );