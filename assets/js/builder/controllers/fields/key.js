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
			// When we add a field, update its key.
			this.listenTo( nfRadio.channel( 'fields' ), 'add:field', this.addKey );

			// When we edit a key, check for places that key might be used.
			this.listenTo( nfRadio.channel( 'fieldSetting-key' ), 'update:setting', this.updateKey );
		},

		/**
		 * Add a key to our new field model.
		 * 
		 * @since 3.0
		 * @param backbone.model model new field model
		 * @return void
		 */
		addKey: function( model ) {
			var num = nfRadio.channel( 'fields' ).request( 'get:tmpID' );
			model.set( 'key', model.get( 'type' ) + '-' + num );
		},

		/**
		 * When a field key is updated, find any merge tags using the key and update them.
		 * 
		 * @since  3.0
		 * @param  backbone.model model field model
		 * @return void
		 */
		updateKey: function( model ) {
			
			console.log( model.changedAttributes().key );
		}

	});

	return controller;
} );