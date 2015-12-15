<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_ProductQuantity
 */
class NF_Fields_Quantity extends NF_Fields_Number
{
    protected $_name = 'quantity';

    protected $_section = 'pricing';

    protected $_aliases = array();

    protected $_type = 'number';

    protected $_templates = 'number';

    protected $_test_value = 'Lorem ipsum';

    public function __construct()
    {
        parent::__construct();

        $settings = $this->load_settings(
           array( 'product_assignment' )
        );
       
        $this->_settings = array_merge( $settings, $this->_settings );
        unset( $this->_settings[ 'required'] );

        $this->_nicename = __( 'Quantity', 'ninja-forms' );
    }
}
