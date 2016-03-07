<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Date
 */
class NF_Fields_Date extends NF_Fields_Textbox
{
    protected $_name = 'date';

    protected $_nicename = 'Date';

    protected $_section = 'common';

    protected $_type = 'date';

    protected $_templates = 'date';

    protected $_test_value = '12/12/2022';

    protected $_settings = array( 'date_default', 'date_format' );

    protected $_settings_exclude = array( 'default', 'placeholder', 'input_limit_set', 'disable_input' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Date', 'ninja-forms' );
    }
}
