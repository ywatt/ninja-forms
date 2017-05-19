/**
 * Model that represents our OAuth connection.
 *
 * @package Ninja Forms client
 * @copyright (c) 2017 WP Ninjas
 * @since 3.2
 */
define( [], function() {
    var model = Backbone.Model.extend( {
        defaults: {
            client_id: '',
            client_secret: '',
            client_token: '',
            client_redirect: ''
        },

        initialize: function() {
            var flag = true;
            this.on( 'change:client_id', this.maybeRequestAccessToken, this );
            this.on( 'change:client_token', function( model, client_token, options ){

                if( 'undefined' == typeof client_token ) return;

                if( flag || client_token.is_expired() ){
                    flag = false;
                    model.unset( 'client_token' );
                    this.maybeRequestAccessToken();
                    return;
                }

                jQuery.ajax( {
                    url: 'https://ninjaforms.dev/wp-json/ninja-forms-auth/v1/example-subscriber',
                    type: 'GET',
                    beforeSend : function( xhr ) {
                        xhr.setRequestHeader( 'Authorization', 'BEARER ' + client_token.access_token );
                    }
                } );

                jQuery.ajax( {
                    url: 'https://ninjaforms.dev/wp-json/ninja-forms-auth/v1/example-admin',
                    type: 'GET',
                    beforeSend : function( xhr ) {
                        xhr.setRequestHeader( 'Authorization', 'BEARER ' + client_token.access_token );
                    }
                } );
            } );
        },

        url: function() {
            return ajaxurl + "?action=nf_oauth";
        },

        parse: function( response, options ){
            return response.data;
        },

        maybeRequestAccessToken: function() {
            if( this.get( 'client_token' ) || ! this.get( 'client_id' ) || ! this.get( 'client_secret' ) ) return;
            jQuery.post( 'https://ninjaforms.dev/oauth/token', {
                'grant_type': 'client_credentials',
                'client_id': this.get( 'client_id' ),
                'client_secret': this.get( 'client_secret' )
            }, this.updateAccessToken.bind( this ) );
        },

        /*
         * @todo Maybe store/cache Access Token in a cookie. See wpCookies (wp/js/utils).
         * @todo Maybe extract all of this into a Token Model.
         */
        updateAccessToken: function( client_token ) {
            if( 'undefined' == typeof client_token.access_token ) return;

            // Determine the expiry for the Access Token.
            var expiry = new Date();
            expiry.setTime( expiry.getTime() + ( parseInt( client_token.expires_in, 10 ) * 1000 ) ); // time must be in milliseconds

            client_token.is_expired = function(){
                var d = new Date();
                return ( expiry.getTime() < d.getTime() );
            };

            this.set( 'client_token', client_token );
        }

    } );

    return model;
} );