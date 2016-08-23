/**
 * @package Ninja Forms builder
 * @subpackage Main App
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
    var controller = Marionette.Object.extend( {

        initialize: function() {
            // The first time settingModel and the dataModel meet.
            this.listenTo( nfRadio.channel( 'setting-type-field-list' ), 'before:renderSetting', this.beforeRender );
        },

        beforeRender: function( settingModel, dataModel ) {

            var fieldCollection = nfRadio.channel( 'fields' ).request( 'get:collection' );

            var fieldTypes = settingModel.get( 'field_types' );

            var options = [];
            _.each( fieldCollection.models, function( field ){

                if( dataModel.cid == field.cid ) return;

                if( 'undefined' != typeof fieldTypes && 0 != fieldTypes.length && ! _.contains( fieldTypes, field.get( 'type' ) ) ) return;

                var fieldFilter = settingModel.get( 'field_filter' );
                if( fieldFilter && 'undefined' != typeof fieldFilter[ field.get( 'type' ) ] ) {
                    var bail = false;
                    _.each( fieldFilter[ field.get( 'type' ) ], function( value, setting ){
                        console.log( value + ":" + field.get( setting )  );
                        if( value != field.get( setting ) ) bail = true;
                    } );
                    if( bail ) return;
                }

                options.push({
                    label: field.get( 'label' ),
                    value: field.get( 'key' )
                });
            });

            settingModel.set( 'options', options );
        },
    });

    return controller;
} );