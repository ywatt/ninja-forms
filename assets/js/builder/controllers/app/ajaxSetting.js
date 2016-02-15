
define( [], function() {
    return Marionette.Object.extend( {
        initialize: function() {
            this.listenTo( nfRadio.channel( 'setting' ), 'ajax', this.addListener );
        },

        addListener: function( model, dataModel ) {

            var listenTo = model.get( 'ajax' ).listen;

            // TODO: Change seems to be triggering twice on each update.
            this.listenTo( nfRadio.channel( 'fieldSetting-' + listenTo ), 'update:setting', this.updateSetting );
            this.listenTo( nfRadio.channel( 'actionSetting-' + listenTo ), 'update:setting', this.updateSetting );

            this.listenTo( nfRadio.channel( 'setting-type-' + model.get( 'type' ) ), 'click:extra', this.clickExtra );

            model.listenTo( nfRadio.channel( 'setting-ajax' ), 'fetch', this.fetch, model );
        },

        clickExtra: function( e, settingModel, dataModel, settingView ) {
            nfRadio.channel( 'setting-ajax' ).trigger( 'fetch', dataModel );
        },

        updateSetting: function( dataModel, settingModel ) {
            nfRadio.channel( 'setting-ajax' ).trigger( 'fetch', dataModel );
        },

        fetch: function( dataModel ) {

            var ajaxSetting = this.get( 'ajax' );

            var data = {
                parentValue: dataModel.get( ajaxSetting.listen ),
                action: ajaxSetting.action,
                security: ( ajaxSetting.security ) ? ajaxSetting.security : nfAdmin.ajaxNonce
            };

            var that = this;
            jQuery.post( ajaxurl, data, function( response ){
                var response = JSON.parse( response );

                if( 'textbox' == that.get( 'type' ) ) {
                    dataModel.set( that.get('name'), response.value );
                }

                if( 'select' == that.get( 'type' ) ) {
                    that.set( 'options', response.options );
                    that.trigger( 'rerender' );
                }
            });
        },

    });
} );