/**
 * When we add a new field, update its key.
 *
 * When we change the key, update any refs to the key.
 * 
 * @package Ninja Forms builder
 * @subpackage Fields
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo( nfRadio.channel( 'fields' ), 'add:field', this.updateKey );
		},

		updateKey: function( model ) {
			var num = nfRadio.channel( 'fields' ).request( 'get:tmpID' );
			model.set( 'key', model.get( 'type' ) + '-' + num );
		}

	});

	return controller;
} );