<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Hidden
 */
class NF_Fields_Hidden extends NF_Abstracts_Input
{
    protected $_name = 'hidden';

    protected $_nicename = 'Hidden';

    protected $_section = '';

    protected $_type = 'hidden';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Hidden', Ninja_Forms::TEXTDOMAIN );
    }
}
