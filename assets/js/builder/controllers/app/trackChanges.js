/**
 * Our undo manager. Currently only changes the 'clean' state of our app when the field model changes.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'update:setting', this.setAppClean, this );
		},

		setAppClean: function( fieldModel ) {
			nfRadio.channel( 'app' ).request( 'update:setting', 'clean', false );
		}

	});

	return controller;
} );