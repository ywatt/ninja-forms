<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Uploads extends NF_Abstracts_Controller
{
    public function __construct()
    {
        add_action( 'wp_ajax_nf_async_upload', array( $this, 'upload' ) );
        add_action( 'wp_ajax_nopriv_nf_async_upload', array( $this, 'upload' ) );
    }

    public function upload()
    {
        $this->_data['file'] = array_values($_FILES)[0];

        $this->_respond();
    }
}