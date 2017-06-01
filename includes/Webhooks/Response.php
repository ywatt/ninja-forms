<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Webhooks_Response
{
    public $data;
    public $status_code;

    public function __construct( $data = array(), $status_code = 200 )
    {
        $this->data = $data;
        $this->status_code = $status_code;
    }

    public function respond( $data = false, $status_code = false )
    {
        if( $status_code ) $this->status_code = $status_code;
        status_header( $this->status_code );

        if( $data ) $this->data = array_merge( $this->data, $data );
        echo json_encode( $this->data );

        exit();
    }

    public function set_status_code( $code )
    {
        $this->status_code = $code;
    }
}
