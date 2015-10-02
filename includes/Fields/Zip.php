<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Zip
 */
class NF_Fields_Zip extends NF_Fields_Textbox
{
    protected $_name = 'zip';

    protected $_nicename = 'Zip';

    protected $_group = 'user_info';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __('Zip', Ninja_Forms::TEXTDOMAIN);
    }
}
