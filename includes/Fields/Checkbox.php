<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Checkbox
 */
class NF_Fields_Checkbox extends NF_Abstracts_Input
{
    const TEMPLATE = 'checkbox';

    protected $_name = 'checkbox';

    protected $_nicename = 'Checkbox';

    protected $_group = 'standard_fields';

    protected $_type = 'checkbox';

    protected $_template ='';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Checkbox', Ninja_Forms::TEXTDOMAIN );
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
