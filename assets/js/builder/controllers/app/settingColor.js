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

            var name = settingModel.get( 'name' );

            jQuery( '#' + name ).wpColorPicker({
                target: '.nf-colorpicker',
                change: function( event, ui ){
                    console.log( ui.color.toString() );
                    console.log( name );
                    // dataModel.set( name, ui.color.toString() );
                }
            });
        }
    });

    return controller;
} );