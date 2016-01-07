<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_ExampleOptIn
 */
class NF_Fields_ExampleOptIn extends NF_Abstracts_FieldOptIn
{
    protected $_name = 'exampleoptin';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Example Opt-In', 'ninja-forms' );

    }
}