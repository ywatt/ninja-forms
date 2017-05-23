/**
 * @package Ninja Forms builder
 * @subpackage Actions - Action Settings Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function( ) {
    var controller = Marionette.Object.extend( {
        initialize: function() {
            this.listenTo( nfRadio.channel( 'actionSetting-from_address' ), 'update:setting', this.updateFromAddress );
        },

        updateFromAddress: function( dataModel, settingModel ) {
            if( 'undefined' == typeof settingModel ) return;

            var value = dataModel.get( 'from_address' );
            var error = false;
            if( value && ! this.isValidEmail( value ) ){
                error = nfi18n.errorInvalidEmailFromAddress;
            }
            settingModel.set( 'error', error );
        },

        isValidEmail: function(email) {
            return /^.+@.+\..+$/.test(email);
        }
    });
    return controller;
} );