/**
 * Merge tags popup
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['views/app/drawer/mergeTagsSection'], function( mergeTagsSectionView ) {
	var view = Marionette.CollectionView.extend({
		tagName: 'div',
		template: '#nf-tmpl-merge-tags-content',
		childView: mergeTagsSectionView
	});

	return view;
} );