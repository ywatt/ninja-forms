/**
 * Listens to our app channel for settings views being rendered.
 *
 * If we're rendering a collect payment setting, add our number fields and total fields to the data model.
 * 
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2017 WP Ninjas
 * @since 3.1.7
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Listen for messages that are fired before a setting view is rendered.
			this.listenTo( nfRadio.channel( 'app' ), 'before:renderSetting', this.beforeRenderSetting );
		},

		beforeRenderSetting: function( settingModel, dataModel, view ) {
			if ( 'field' == settingModel.get( 'total_type' ) ) {
				var fields = this.getFields( settingModel );
				settingModel.set( 'options', fields );
			}
		},

		getFields: function( settingModel ) {
			var returnFields = [ settingModel.get( 'default_options' ) ];
			// Update our dataModel with all of our product fields.
			var fields = nfRadio.channel( 'fields' ).request( 'get:collection' );
			_.each( fields.models, function( field ) {
				if ( 'number' == field.get( 'type' ) || 'total' == field.get( 'type' ) ) {
					returnFields.push( { label: field.get( 'label' ), value: '{field:' + field.get( 'key' ) + '}' } );
				}
			} );

			returnFields = _.sortBy( returnFields, function( field ) { return field.label } );

			return returnFields;
		}

	});

	return controller;
} );