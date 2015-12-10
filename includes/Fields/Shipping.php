<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Shipping
 */
class NF_Fields_Shipping extends NF_Abstracts_Input
{
    protected $_name = 'shipping';

    protected $_section = 'pricing';

    protected $_aliases = array();

    protected $_type = 'textbox';

    protected $_templates = 'textbox';

    protected $_test_value = 'Lorem ipsum';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'default' )
        );

        $this->_nicename = __( 'Shipping', 'ninja-forms' );
    }
}
