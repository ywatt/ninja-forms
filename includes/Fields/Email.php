<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Email
 */
class NF_Fields_Email extends NF_Abstracts_UserInfo
{
    const TEMPLATE = 'email';

    protected $_name = 'email';

    protected $_nicename = 'Email';

    protected $_type = 'email';

    protected $_section = 'userinfo';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Email', Ninja_Forms::TEXTDOMAIN );

    }
}
