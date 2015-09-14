<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_Abstracts_Controller
{
    protected $_errors = array();

    protected $_data = array();

    public function __construct()
    {
        // TODO: Check Nonce
    }

    protected function _respond()
    {
        $response = array( 'errors' => $this->_errors, 'data' => $this->_data );

        echo json_encode( $response );

        wp_die(); // this is required to terminate immediately and return a proper response
    }
}