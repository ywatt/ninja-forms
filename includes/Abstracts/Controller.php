<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_Abstracts_Controller
{
    /**
     * Data (Misc.) passed back to the client in the Response.
     *
     * @var array
     */
    protected $_data = array();

    /*
     * PUBLIC METHODS
     */

    public function __construct()
    {
        // TODO: Add Nonce Check
    }

    /*
     * PROTECTED METHODS
     */

    protected function _respond()
    {
        $response = array( 'errors' => $this->_errors, 'data' => $this->_data );

        echo wp_json_encode( $response );

        wp_die(); // this is required to terminate immediately and return a proper response
    }
}