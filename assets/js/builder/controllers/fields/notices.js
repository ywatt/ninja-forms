/**
 * Creates notices for our fields domain.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'add:stagedField', this.addStagedField );
		},

		addStagedField: function( model ) {
			/*
			 * If we're using a mobile browser, set specific notice settings.
			 */
			if ( nfRadio.channel( 'app' ).request( 'is:mobile' ) ) {
				var position = {
					x: 'center',
					y: 'top'
				}
				var attributes = {};
				var animation = {
					open:'slide:top',
					close:'move:left'
				}
				var autoClose = 1000;
				var offset = {
					x: 0,
					y: 55
				}
			} else {
				var position = {};
				var attributes = {
					x: 'left',
					y: 'bottom'
				}
				var animation = {
					open:'slide:bottom',
					close:'move:left'
				}
				var autoClose = 3000;
				var offset = {
					x: 0,
					y: 0
				}
			}

			new jBox( 'Notice', {
				animation: animation,
				theme: 'NoticeBorder',
				position: position,
				attributes: attributes,
				offset: offset,
				autoClose: autoClose,
				content: model.get( 'nicename' ) + ' added to staging',
				color: 'green',
				zIndex:12000
			} );
			
		}
	});

	return controller;
} );