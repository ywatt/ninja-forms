<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Form extends NF_Abstracts_Controller
{
    public function __construct()
    {
        add_action( 'wp_ajax_nf_save_form',   array( $this, 'save' )   );
        add_action( 'wp_ajax_nf_delete_form', array( $this, 'delete' ) );
        add_action( 'wp_ajax_nf_preview_form', array( $this, 'preview' ) );
    }

    public function save()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        $this->_respond();
    }

    public function delete()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        $this->_respond();
    }

    public function preview()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        $this->_respond();
    }
}
