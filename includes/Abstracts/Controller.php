<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_Abstracts_Controller
{
    public $errors = array();

    public function __construct()
    {
        // TODO: Check Nonce
    }

}