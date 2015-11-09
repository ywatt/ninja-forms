<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Address
 */
class NF_Fields_Address extends NF_Abstracts_UserInfo
{
    protected $_name = 'address';

    protected $_nicename = 'Address';

    protected $_section = 'userinfo';

    protected $_templates = array( 'address', 'textbox', 'input' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Address', 'ninja-forms' );
    }
}
