/**
 * Listens to our app channel for settings views being rendered.
 *
 * If we haven't set a total_type, then set the total_type to fixed.
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
            if ( 'payment_total' != settingModel.get( 'name' ) ) return false;

            if ( 'undefined' == dataModel.get( 'payment_total_type') && 'undefined' != dataModel.get( 'payment_total' ) ) {
                dataModel.set( 'payment_total_type', 'fixed' );
            }
        },

    });

    return controller;
} );