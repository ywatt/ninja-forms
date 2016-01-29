/**
 * @package Ninja Forms builder
 * @subpackage Actions - New Action Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function( ) {
    var controller = Marionette.Object.extend( {
        initialize: function() {
            this.listenTo( nfRadio.channel( 'setting-type-newsletter_list' ), 'click:extra', this.clickListUpdate );
            this.listenTo( nfRadio.channel( 'setting-name-newsletter_list_fieldset' ), 'init:settingModel', this.registerListener );
            this.listenTo( nfRadio.channel( 'actionSetting-newsletter_list' ), 'update:setting', this.maybeRenderFieldset );
        },

        maybeRenderFieldset: function( lists ) {
            // model.changedAttributes(); -> { name: new_value } If name is list, then
            // Use: nfRadio.channel( 'newsletter_list_fieldset').trigger( 'update:fieldMapping', response.lists );
            console.log( 'change list' );

        },

        registerListener: function ( model ) {
            model.listenTo( nfRadio.channel( 'newsletter_list_fieldset' ), 'update:fieldMapping', this.updateFieldMapping, model );
        },

        clickListUpdate: function( e, settingModel, dataModel, settingView ) {
            var data = {
                action: 'nf_' + dataModel.attributes.type + '_get_lists',
                security: nfAdmin.ajaxNonce
            };

            var that = this;
            jQuery.post( ajaxurl, data, function( response ){
                var response = JSON.parse( response );
                that.updateLists( settingModel, response.lists, settingView, dataModel );
                dataModel.set( 'newsletter_list', response.lists[0].value );
            });
        },

        updateLists: function( settingModel, lists, settingView, dataModel ) {
            settingModel.set( 'options', lists );
            settingView.render();
        },

        updateFieldMapping: function( lists ) {
           var settings = this.get( 'settings' );
            settings.reset();
            _.each( lists, function( list ){

                _.each( list.fields, function( field ) {
                    var newSetting = settings.add({
                        name: field.value,
                        type: 'textbox',
                        label: field.label,
                        width: 'full',
                        use_merge_tags: {
                            exclude: [
                                'user', 'post', 'system', 'querystrings'
                            ]
                        }
                    });
                });
            });
            this.set( 'settings', settings );
        }

    });

    return controller;
} );
