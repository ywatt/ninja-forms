<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Preview extends NF_Abstracts_Controller
{
    public function __construct()
    {
        add_action( 'wp_ajax_nf_preview_form', array( $this, 'form' ) );
        add_action( 'wp_ajax_nf_preview_field', array( $this, 'field' ) );
    }

    public function field()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        if( isset( $_POST['field'] ) ){
            $this->_data[ 'field' ] = $_POST[ 'field' ];
        }

        $this->_respond();
    }
}
