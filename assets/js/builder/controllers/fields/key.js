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

			// When we edit a label, update our key.
			this.listenTo( nfRadio.channel( 'fieldSetting-label' ), 'update:setting', this.updateLabel );

			// When we edit a key, check for places that key might be used.
			this.listenTo( nfRadio.channel( 'fieldSetting-key' ), 'update:setting', this.updateKey );

			// When we type inside the admin key field, we need to save our manual_key setting.
			this.listenTo( nfRadio.channel( 'setting-key' ), 'keyup:setting', this.keyUp );

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
			model.set( 'manual_key', false );
		},

		updateLabel: function( model ) {

			/*
			 * If we haven't entered a key manually, update our key when our label changes.
			 */
			if ( ! model.get( 'manual_key' ) ) {
				/*
				 * When we're editing settings, we expect the edits to fire one at a time.
				 * Since we're calling this in the middle of our label update, anything that inquires about what has changed after we set our key will see both label and key.
				 * We need to remove the label from our model.changed property so that all that has changed is the key.
				 * 
				 */
				delete model.changed.label;
				model.set( 'key', jQuery.slugify( model.get( 'label' ) ) );				
			}
		},

		/**
		 * When a field key is updated, find any merge tags using the key and update them.
		 * 
		 * @since  3.0
		 * @param  backbone.model model field model
		 * @return void
		 */
		updateKey: function( model ) {
			nfRadio.channel( 'app' ).trigger( 'update:fieldKey', model );
		},

		keyUp: function( e, settingModel, dataModel ) {
			dataModel.set( 'manual_key', true );
		}

	});

	return controller;
} );