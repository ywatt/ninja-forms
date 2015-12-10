<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Product
 */
class NF_Fields_Product extends NF_Abstracts_Input
{
    protected $_name = 'product';

    protected $_section = 'pricing';

    protected $_aliases = array();

    protected $_type = 'textbox';

    protected $_templates = 'product';

    protected $_test_value = 'Lorem ipsum';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'product_use_quantity', 'product_price', 'product_type', 'product_type' )
        );

        $this->_nicename = __( 'Product', 'ninja-forms' );
    }
}
