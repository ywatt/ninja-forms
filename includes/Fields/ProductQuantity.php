<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_ProductQuantity
 */
class NF_Fields_ProductQuantity extends NF_Abstracts_Input
{
    protected $_name = 'product_quantity';

    protected $_section = 'pricing';

    protected $_aliases = array();

    protected $_type = 'textbox';

    protected $_templates = 'quantity';

    protected $_test_value = 'Lorem ipsum';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'classes' )
        );

        $this->_nicename = __( 'Quantity', 'ninja-forms' );
    }
}
