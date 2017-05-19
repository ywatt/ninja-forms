jQuery(document).ready(function($) {
    $( '.js-delete-saved-field' ).click( function(){

        var that = this;

        var data = {
            'action': 'nf_delete_saved_field',
            'field': {
                id: $( that ).data( 'id' )
            },
            'security': nf_settings.nonce
        };

        $.post( nf_settings.ajax_url, data )
            .done( function( response ) {
                $( that ).closest( 'tr').fadeOut().remove();
            });
    });

    $( '.js-oauth-disconnect' ).click( function(){

        $button = jQuery( this );
        $button.text( 'Disconnecting...' );

        $.ajax({
            url: 'https://ninjaforms.dev/oauth/disconnect',
            type: 'DELETE',
            data: {
                client_id: nf_settings.oauth_client_id,
                client_secret: nf_settings.oauth_client_secret,
                debug: nf_settings.debug
            },
            success: function() {
                $.ajax( {
                    url: nf_settings.ajax_url + '?action=nf_oauth',
                    method: 'DELETE',
                    data:{
                        'nonce': nf_settings.oauth_nonce
                    },
                    success: function( response ){
                        response = JSON.parse( response );
                        if( 'undefined' != typeof response.errors && 0 != response.errors.length ) {
                            $button.text( 'Disconnect - Error' );
                            return;
                        }
                        $button.text('Disconnected');
                        $button.attr('disabled', 'disabled');
                    }
                } );
            }
        });
    });
});
