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

            // The first time settingModel and the dataModel meet.
            this.listenTo( nfRadio.channel( 'setting-type-color' ), 'attach:setting', this.init );
        },

        init: function( settingModel, dataModel ) {
            jQuery('.js-ninja-forms-styles-color-field').wpColorPicker({
                target: '.nf-colorpicker',
                change: this.update
            });
        },

        update: function( event, ui ) {

            console.log( ui.color.toString() );
            // Mirror the default value setting value.
            // dataModel.set( this.get( 'name' ), changedSettingValue );
        }
    });

    return controller;
} );