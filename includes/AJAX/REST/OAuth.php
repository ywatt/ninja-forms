<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_REST_OAuth extends NF_AJAX_REST_Controller
{
    protected $action = 'nf_oauth';

    public function __construct()
    {
        parent::__construct();
        add_action( 'init', array( $this, 'maybe_update_client_id' ) );
    }

    public function maybe_update_client_id()
    {
        if( isset( $_GET[ 'page' ] ) && 'ninja-forms' == $_GET[ 'page' ] ) {
            // TODO: Register the client_id query var.
            if ( isset( $_GET[ 'client_id' ] ) ) {
                // TODO: Move functionality outside of the REST Controller.
                update_site_option( 'ninja_forms_client_id', sanitize_text_field( $_GET[ 'client_id' ] ) );
                wp_redirect( add_query_arg( 'page', 'ninja-forms', admin_url() ) );
                exit();
            }
        }
    }

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
            'client_redirect' => urlencode( add_query_arg( 'page', 'ninja-forms', admin_url() ) ),
        ) );
    }

    public function delete()
    {
        delete_site_option( 'ninja_forms_client_id' );
        delete_site_option( 'ninja_forms_client_secret' );
        $this->_respond();
    }

    protected function get_request_data()
    {
        $data = array();

        if( 'DELETE' == $_SERVER['REQUEST_METHOD'] ){
            parse_str( file_get_contents( 'php://input' ), $request_data );
            if ( ! wp_verify_nonce( $request_data[ 'nonce' ], 'nf_oauth' ) ) {
                $this->_errors[ 'nonce' ] = 'The nonce does not match';
                $this->_respond();
            }
        }

        return $data;
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
