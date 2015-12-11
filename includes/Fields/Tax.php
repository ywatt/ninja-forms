<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Tax
 */
class NF_Fields_Tax extends NF_Abstracts_Input
{
    protected $_name = 'tax';

    protected $_section = 'pricing';

    protected $_aliases = array();

    protected $_type = 'textbox';

    protected $_templates = 'tax';

    protected $_test_value = '0.00';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'tax_rate' )
        );

        $this->_nicename = __( 'Tax', 'ninja-forms' );
    }
}
