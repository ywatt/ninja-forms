/**
 * Merge tags popup
 *
 * @package Ninja Forms builder
 * @subpackage App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['views/app/drawer/mergeTagsSection'], function( mergeTagsSectionView ) {
	var view = Marionette.LayoutView.extend({
		tagName: 'div',
		template: '#nf-tmpl-merge-tags-content',
		regions: {
			fields: '.merge-tags-fields',
			system: '.merge-tags-system',
			userInfo: '.merge-tags-user-info'
		},

		initialize: function() {
			this.render();
		},

		onRender: function() {
			var mergeTags = nfRadio.channel( 'mergeTags' ).request( 'get:mergeTags' );
			this.fields.show( new mergeTagsSectionView( { collection: mergeTags.fields } ) );
			this.system.show( new mergeTagsSectionView( { collection: mergeTags.system } ) );
			this.userInfo.show( new mergeTagsSectionView( { collection: mergeTags.userInfo } ) );
		},

		events: {
			'keydown': 'moveFocus'
		},

		moveFocus: function( e ) {
			// console.log( e.keyCode );
		}
	});

	return view;
} );