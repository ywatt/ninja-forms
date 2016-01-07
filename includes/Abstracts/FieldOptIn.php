<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_FieldOptIn
 */
class NF_Abstracts_FieldOptIn extends NF_Abstracts_Input
{
    protected $_name = 'optin';

    protected $_section = 'misc';

    protected $_type = 'optin';

    protected $_templates = 'optin';

    protected $_settings = array( 'type' );

    protected $_settings_exclude = array( 'required', 'placeholder' );

    public function __construct()
    {
        parent::__construct();

        $this->_settings[ 'type' ][ 'options' ] = array(
            array(
                'label'     => __( 'Single', 'ninja-forms' ),
                'value'     => 'single',
            ),
            array(
                'label'     => __( 'Multiple', 'ninja-forms' ),
                'value'     => 'multiple',
            ),
        );
    }
}