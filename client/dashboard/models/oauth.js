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
            access_token: '',
            client_redirect: ''
        },

        url: function() {
            return ajaxurl + "?action=nf_oauth";
        },

        parse: function( response, options ){
            return response.data;
        },

    } );

    return model;
} );