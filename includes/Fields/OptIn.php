<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_OptIn
 */
class NF_Fields_OptIn extends NF_Fields_Checkbox
{
    protected $_name = 'optin';

    protected $_section = 'misc';

    protected $_type = 'checkbox';

    protected $_templates = 'checkbox';

    protected $_test_value = 0;

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Opt-In', 'ninja-forms' );

    }
}
