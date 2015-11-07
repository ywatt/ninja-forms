<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_FirstName
 */
class NF_Fields_FirstName extends NF_Abstracts_UserInfo
{
    protected $_name = 'firstname';

    protected $_nicename = 'First Name';

    protected $_section = 'userinfo';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'First Name', 'ninja-forms' );
    }
}
