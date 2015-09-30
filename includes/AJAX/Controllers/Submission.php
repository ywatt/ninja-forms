<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Submission extends NF_Abstracts_Controller
{
    protected $_form_data = array();

    protected $_form_id = '';

    public function __construct()
    {
        if( isset( $_POST['formData'] ) ) $this->_form_data = json_decode( $_POST['formData'], TRUE );

        add_action( 'wp_ajax_nf_ajax_submit',   array( $this, 'process' )  );
        add_action( 'wp_ajax_nopriv_nf_ajax_submit',   array( $this, 'process' )  );
    }

    public function process()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        if( ! $this->_form_data ) {
            $this->_errors[] = 'Form Data not found.';
            $this->_respond();
        }

        $this->_form_id = $this->_form_data['id'];

        $this->_data['fields'] = $this->_form_data['fields'];

//        $this->validate_fields();
//
        $this->run_actions();

        $this->_respond();
    }

    protected function validate_fields()
    {

    }

    protected function run_actions()
    {
        $actions = Ninja_Forms()->form( $this->_form_id )->get_actions();

        foreach( $actions as $action ){

            if( ! $action->get_setting( 'active' ) ) continue;

            $type = $action->get_setting( 'type' );

            $data = Ninja_Forms()->actions[ $type ]->process( $action->get_id(), $this->_form_id, $this->_data );

            $this->_data = ( $data ) ? $data :  $this->_data;
        }
    }
}