<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_REST_OAuth extends NF_AJAX_REST_Controller
{
    protected $action = 'nf_oauth';

    /**
     * @return array
     */
    public function get()
    {
        $this->_respond( array(
            'client_id' => '',
            'client_secret' => 'foobar',
            'access_token' => '',
            'client_redirect' => urlencode( add_query_arg( 'page', 'ninja-forms', admin_url() ) )
        ) );
    }
}
