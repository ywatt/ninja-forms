<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_RadioList
 */
class NF_Fields_RadioList extends NF_Abstracts_List
{
    protected $_name = 'radiolist';

    protected $_nicename = 'Radio List';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Radio List', Ninja_Forms::TEXTDOMAIN );
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
