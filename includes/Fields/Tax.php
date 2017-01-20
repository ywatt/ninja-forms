<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Tax
 */
class NF_Fields_Tax extends NF_Abstracts_Input
{
    protected $_name = 'tax';

    protected $_section = 'pricing';

    protected $_icon = 'money';

    protected $_aliases = array();

    protected $_type = 'tax';

    protected $_templates = 'tax';

    protected $_test_value = '0.00';

    protected $_settings_exclude = array( 'placeholder', 'default', 'input_limit_set', 'disable_input', 'required' );
    
    protected $_settings = array( 'tax_rate' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Tax', 'ninja-forms' );
    }
}
