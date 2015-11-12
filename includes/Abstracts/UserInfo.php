<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_UserInfo
 */
abstract class NF_Abstracts_UserInfo extends NF_Abstracts_Input
{
    protected $_name = 'input';

    protected $_section = 'userinfo';

    protected $_type = 'textbox';

    public function __construct()
    {
        parent::__construct();
    }
}
