<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Action
{
    public function __construct()
    {
        add_action( 'wp_ajax_nf_save_action',   array( $this, 'save' )   );
        add_action( 'wp_ajax_nf_delete_action', array( $this, 'delete' ) );
    }

    public function save()
    {

    }

    public function delete()
    {

    }
}