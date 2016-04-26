/**
 * Listens to our app channel for settings views being rendered.
 *
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
    var controller = Marionette.Object.extend( {
        initialize: function() {

            // Bind field key listener to field-select setting type.
            this.listenTo( nfRadio.channel( 'field-select' ), 'init:settingModel', this.trackKeyChanges );

            // The first time settingModel and the dataModel meet.
            this.listenTo( nfRadio.channel( 'setting-type-field-select' ), 'before:renderSetting', this.beforeRender );
        },

        trackKeyChanges: function( settingModel ) {
            settingModel.listenTo( nfRadio.channel( 'app' ), 'update:fieldKey', settingModel.updateKey );

            // Update selected field if the selected field's key changes.
            this.listenTo( nfRadio.channel( 'app' ), 'replace:fieldKey', this.updateFieldMap );
        },

        updateFieldMap: function( dataModel, keyModel, settingModel ) {

            var oldKey = keyModel._previousAttributes[ 'key' ];
            var newKey = keyModel.get( 'key' );

            if( 'field-select' == settingModel.get( 'type' ) && dataModel.get( settingModel.get( 'name' ) ) == oldKey ) {

                dataModel.set( settingModel.get( 'name' ), newKey );
            }
        },

        beforeRender: function( settingModel, dataModel ) {

            if( 'undefined' == settingModel.get( 'field_types' ) ) return;

            var fieldCollection = nfRadio.channel( 'fields' ).request( 'get:collection' );

            var fieldTypes = settingModel.get( 'field_types' );

            var options = [
                {
                    label: '--',
                    value: false
                }
            ];
            _.each( fieldCollection.models, function( field ){

                if( dataModel.get( 'id' ) == field.get( 'id' ) ) return;

                if( 'undefined' != typeof fieldTypes && 0 != fieldTypes.length && ! _.contains( fieldTypes, field.get( 'type' ) ) ) return;

                options.push({
                    label: field.get( 'label' ),
                    value: field.get( 'key' )
                });
            });

            settingModel.set( 'options', options );
        }
    });

    return controller;
} );