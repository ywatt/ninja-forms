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
            this.listenTo( nfRadio.channel( 'setting-newsletter_list' ), 'show:setting', this.defaultFields );
            this.listenTo( nfRadio.channel( 'setting-name-newsletter_list' ), 'init:settingModel', this.addEmptyOption );
            this.listenTo( nfRadio.channel( 'actionSetting-newsletter_list' ), 'update:setting', this.maybeRenderFieldset );
        },

        defaultFields: function( settingModel, dataModel ) {
            this.maybeRenderFieldset( dataModel, settingModel );
        },

        addEmptyOption: function( model ) {
            var lists = model.get( 'options' );
            lists.unshift({ label: '-', value: 0, fields: [] });
            model.set( 'options', lists );
        },

        maybeRenderFieldset: function( dataModel, settingModel ) {

            if( 'undefined' == typeof settingModel ) return;

            var selectedList = dataModel.get( 'newsletter_list' );
            var lists = settingModel.get( 'options' );
            _.each( lists, function( list ) {
                if ( selectedList == list.value ) {
                    nfRadio.channel( 'newsletter_list_fieldset').trigger( 'update:fieldMapping', list.fields );
                }
            } );

            dataModel.set( 'newsletter_list_fieldset', 0 );
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
                dataModel.set( 'newsletter_list', response.lists[0].value, { settingModel: settingModel } );
            });
        },

        updateLists: function( settingModel, lists, settingView, dataModel ) {
            lists.unshift({ label: '-', value: 0, fields: [] });
            settingModel.set( 'options', lists );
            settingView.render();
        },

        updateFieldMapping: function( fields ) {
           var settings = this.get( 'settings' );
            settings.reset();
            _.each( fields, function( field ){

                settings.add({
                    name: field.value,
                    type: 'textbox',
                    label: field.label,
                    width: 'full',
                    use_merge_tags: { exclude: [ 'user', 'post', 'system', 'querystrings' ] }
                });
            });
            this.set( 'settings', settings );
        }

    });

    return controller;
} );
