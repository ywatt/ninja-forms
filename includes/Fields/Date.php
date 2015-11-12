<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Date
 */
class NF_Fields_Date extends NF_Abstracts_Input
{
    protected $_name = 'date';

    protected $_nicename = 'Date';

    protected $_section = '';

    protected $_type = 'textbox';

    protected $_templates = array( 'date', 'textbox', 'input' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Date', 'ninja-forms' );
    }
}
