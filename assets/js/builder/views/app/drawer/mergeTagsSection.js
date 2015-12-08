/**
 * Merge tags popup section
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['views/app/drawer/mergeTagItem'], function( mergeTagItemView ) {
	var view = Marionette.CollectionView.extend({
		tagName: 'div',
		childView: mergeTagItemView
	});

	return view;
} );