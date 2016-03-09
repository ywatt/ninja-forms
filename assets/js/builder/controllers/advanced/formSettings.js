/**
 * Fetches settings models so that we can get setting information
 * 
 * @package Ninja Forms builder
 * @subpackage Advanced
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( ['models/app/settingCollection'], function( settingCollection ) {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			this.collection = new settingCollection( formSettings, { objectType: 'settings' } );
			
			/*
			 * Loop through our setting models and get their types to see if we have any defaults.
			 */
			_.each( this.collection.models, function( setting ) {
				// console.log( setting.get( 'name' ) + ' ' + setting.get( 'value' ) );
			} );
			/*
			// Loop through our field type "settingDefaults" and add any default settings.
			var that = this;
			_.each( fieldType.get( 'settingDefaults' ), function( val, key ) {
				if ( 'undefined' == typeof that.get( key ) ) {
					that.set( key, val, { silent: true } );
				}
			} );
			*/
		
			// Responds to requests for settings models.
			nfRadio.channel( 'settings' ).reply( 'get:settingModel', this.getSettingModel, this );
		},

		getSettingModel: function( name ) {
			return this.collection.findWhere( { name: name } );
		}

	});

	return controller;
} );