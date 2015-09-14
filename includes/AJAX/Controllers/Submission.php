<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Submission
{
    public function __construct()
    {
        add_action( 'wp_ajax_nf_process_submission',   array( $this, 'process' )   );
    }

    public function process()
    {
        $this->_respond();
    }
}