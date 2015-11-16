<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_UserInfo
 */
abstract class NF_Abstracts_UserInfo extends NF_Fields_Textbox
{
    protected $_name = 'input';

    protected $_section = 'userinfo';

    protected $_type = 'textbox';

    public static $_base_template = 'textbox';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'required', 'user_info_default_value', 'placeholder', 'classes' )
        );
    }
}
