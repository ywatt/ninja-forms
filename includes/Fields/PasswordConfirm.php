<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_PasswordConfirm
 */
class NF_Fields_PasswordConfirm extends NF_Fields_Password
{
    protected $_name = 'passwordconfirm';

    protected $_nicename = 'Password Confirm';

    protected $_section = '';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Password Confirm', 'ninja-forms' );
    }
}
