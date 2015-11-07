<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Checkbox
 */
class NF_Fields_Checkbox extends NF_Abstracts_Input
{
    protected $_name = 'checkbox';

    protected $_nicename = 'Checkbox';

    protected $_section = 'common';

    protected $_type = 'checkbox';

    protected $_templates = array( 'checkbox', 'input' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Checkbox', 'ninja-forms' );
    }
}
