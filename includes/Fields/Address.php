<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Address
 */
class NF_Fields_Address extends NF_Fields_Textbox
{
    protected $_name = 'address';

    protected $_nicename = 'Address';

    protected $_group = 'user_info';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Address', Ninja_Forms::TEXTDOMAIN );
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
