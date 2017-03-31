/**
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [ 'views/app/drawer/mergeTagGroup' ], function( mergeTagGroupView ) {
    var view = Marionette.CollectionView.extend({
        childView: mergeTagGroupView
    });

    return view;
} );