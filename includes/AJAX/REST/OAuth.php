<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_REST_OAuth extends NF_AJAX_REST_Controller
{
    protected $action = 'nf_oauth';

    /**
     * @return array [ client_id, client_secret, client_redirect ]
     */
    public function get()
    {
        // TODO: Move functionality outside of the REST Controller.
        $client_id     = get_site_option( 'ninja_forms_client_id',     false );
        $client_secret = get_site_option( 'ninja_forms_client_secret', false );
        if( ! $client_secret ) {
            $client_secret = $this->generate_key();
            update_site_option( 'ninja_forms_client_secret', $client_secret );
        }

        $this->_respond( array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'client_redirect' => urlencode( add_query_arg( 'page', 'ninja-forms', admin_url() ) )
        ) );
    }

    /**
     * Ported from WP OAuth Server Pro
     * TODO: Move functionality outside of the REST Controller.
     *
     * @param int $length
     * @return string $random_string
     */
    private function generate_key( $length = 40 )
    {
        if( 0 >= $length ) $length = 40; // Min key length.
        if( 255 <= $length ) $length = 255; // Max key length.

        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';

        for ( $i = 0; $i < $length; $i ++ ) {
            $random_string .= $characters[ rand( 0, strlen( $characters ) - 1 ) ];
        }

        return $random_string;
    }
}
