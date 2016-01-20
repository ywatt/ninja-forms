/**
 * Handles mobile-specific JS for our fields domain.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Listen for the start of our sorting.
			this.listenTo( nfRadio.channel( 'app' ), 'render:fieldsSortable', this.initWiggle );
			// Listen for when we start sorting.
			this.listenTo( nfRadio.channel( 'fields' ), 'sortable:start', this.startWiggle );
			// Listen for when we stop sorting.
			this.listenTo( nfRadio.channel( 'fields' ), 'sortable:stop', this.stopWiggle );
		},

		initWiggle: function( view ) {
			var fieldELs = jQuery( view.el ).find( '.nf-field-wrap' ).ClassyWiggle( { delay: 70 } );
			jQuery( fieldELs ).on( 'taphold', function() {
				jQuery( this ).ClassyWiggle( 'start' );
			} );
			// if ( nfRadio.channel( 'app' ).request( 'is:mobile' ) ) {
				// jQuery( ui.helper ).ClassyWiggle( 'start', { delay: 70 } );
			// }
		},

		startWiggle: function( ui ) {
			jQuery( ui.item ).ClassyWiggle( 'stop' );
			jQuery( ui.helper ).ClassyWiggle( 'start', { delay: 70 } );
		},

		stopWiggle: function( ui ) {
			// if ( nfRadio.channel( 'app' ).request( 'is:mobile' ) ) {
				jQuery( ui.helper ).ClassyWiggle( 'stop' );
			// }
		}

	});

	return controller;
} );
