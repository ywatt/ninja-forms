define( [], function() {
    return Marionette.Object.extend( {
        initialize: function() {
            this.listenTo( nfRadio.channel( 'setting' ), 'ajax', this.addListener );
        },

        addListener: function( model, dataModel ) {
            var listenTo = model.get( 'ajax' ).listen;

            // TODO: Change seems to be triggering twice on each update.
            this.listenTo( nfRadio.channel( 'fieldSetting-' + listenTo ), 'update:setting', this.updateSetting );

            model.listenTo( nfRadio.channel( 'fieldSetting-ajax' ), 'fetch', this.fetch, model );
        },

        updateSetting: function( field, setting ) {
            nfRadio.channel( 'fieldSetting-ajax' ).trigger( 'fetch', field );
        },

        fetch: function( parentModel ) {
            var action  = this.get( 'ajax' ).action;
            var listen = this.get( 'ajax' ).listen;

            var data = {
                parentValue: parentModel.get( listen ),
                action: this.get( 'ajax' ).action,
                security: ( this.get( 'ajax' ).security ) ? this.get( 'ajax' ).security : nfAdmin.ajaxNonce
            };

            var that = this;
            jQuery.post( ajaxurl, data, function( response ){
                var response = JSON.parse( response );

                if( 'textbox' == that.get( 'type' ) ) {
                    parentModel.set( that.get('name'), response.value );
                }

                if( 'select' == that.get( 'type' ) ) {
                    that.set( 'options', response.options );
                    that.trigger( 'rerender' );
                }
            });
        },

    });
} );