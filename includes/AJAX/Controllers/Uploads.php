<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Uploads extends NF_Abstracts_Controller
{
    protected $_blacklist = array();

    public function __construct()
    {
        parent::__construct();

        $this->_blacklist = apply_filters( 'ninja_forms_uploads_extension_blacklist', Ninja_Forms::config( 'UploadsExtensionBlacklist' ) );

        add_action( 'wp_ajax_nf_async_upload', array( $this, 'upload' ) );
        add_action( 'wp_ajax_nopriv_nf_async_upload', array( $this, 'upload' ) );

    }

    public function upload()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        $this->_data['file'] = array_values($_FILES)[0];

        $this->_respond();
    }

    /*
     * TEMPORARY OVERRIDE FOR TESTING
     */
    protected function _respond()
    {
        echo array_values($_FILES)[0]['name'];
        die();
    }

}
