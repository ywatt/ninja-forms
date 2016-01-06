<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_CreditCardNumber
 */
class NF_Fields_CreditCardNumber extends NF_Abstracts_Field
{
    protected $_name = 'creditcardnumber';

    protected $_section = '';

    protected $_templates = '';

    protected $_test_value = '';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Credit Card Number', 'ninja-forms' );
    }
}
