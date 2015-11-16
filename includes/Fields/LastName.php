<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_FirstName
 */
class NF_Fields_LastName extends NF_Abstracts_UserInfo
{
    protected $_name = 'lastname';

    protected $_nicename = 'Last Name';

    protected $_section = 'userinfo';

    protected $_templates = 'lastname';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Last Name', 'ninja-forms' );
    }
}
