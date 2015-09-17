<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Submission extends NF_Abstracts_Controller
{
    protected $_field_values = array();

    public function __construct()
    {
        add_action( 'wp_ajax_nf_process_submission',   array( $this, 'process' )  );
        add_action( 'wp_ajax_nopriv_nf_process_submission',   array( $this, 'process' )  );
    }

    public function process()
    {
        $this->_form_id = $_POST['nf_form'][ 'id' ];

        $this->_actions = Ninja_Forms()->form( $this->_form_id )->get_actions();

        foreach( $_POST['nf_form']['fields'] as $field ){

            $field_id = $field['id'];
            $this->_data['field_values'][ $field_id ] = $field['value'];
        }

        $this->_errors[ 'sample' ] = 'This is a sample error';

        $this->run_actions();

        $this->_respond();
    }

    protected function validate_fields()
    {

    }

    protected function run_actions()
    {
        foreach( $this->_actions as $action ){
            $type = $action->get_settings( 'type' );

            $data = Ninja_Forms()->actions[ $type ]->process( $this->_data );

            $this->_data = ( $data ) ? $data :  $this->_data;
        }
    }
}