<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_City
 */
class NF_Fields_City extends NF_Abstracts_UserInfo
{
    protected $_name = 'city';

    protected $_nicename = 'City';

    protected $_section = 'userinfo';

    protected $_templates = 'city';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'City', 'ninja-forms' );
    }
}
