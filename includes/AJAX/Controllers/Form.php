<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Form extends NF_Abstracts_Controller
{
    public function __construct()
    {
        parent::__construct();

        add_action( 'wp_ajax_nf_save_form',   array( $this, 'save' )   );
        add_action( 'wp_ajax_nf_delete_form', array( $this, 'delete' ) );
    }

    public function save()
    {
        $this->_respond();
    }

    public function delete()
    {
        $this->_respond();
    }
}
