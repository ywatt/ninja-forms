/**
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [ 'views/app/drawer/mergeTag' ], function( mergeTagView ) {
    var view = Marionette.CollectionView.extend({
        tagName: 'ul',
        childView: mergeTagView
    });

    return view;
} );