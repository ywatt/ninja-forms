/**
 * Main content view for our actions.
 *
 * TODO: make dynamic
 * 
 * @package Ninja Forms builder
 * @subpackage Actions
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['builder/views/actions/actionItem'], function( actionView ) {
	var view = Marionette.CompositeView.extend({
		template: '#nf-tmpl-action-table',
		childView: actionView,
		// emptyView: emptyView,

		attachHtml: function( collectionView, childView ) {
			jQuery( collectionView.el ).find( 'tbody' ).append( childView.el );
		},
	});

	return view;
} );