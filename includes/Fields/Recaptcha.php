<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_CreditCard
 */
class NF_Fields_Recaptcha extends NF_Abstracts_Field
{
    protected $_name = 'recaptcha';

    protected $_section = 'misc';

    protected $_templates = 'recaptcha';

    protected $_test_value = '';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Recaptcha', 'ninja-forms' );
    }
}
