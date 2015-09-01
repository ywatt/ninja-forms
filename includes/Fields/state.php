<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_StateList
 */
class NF_Fields_StateList extends NF_Abstracts_List
{
    protected $_name = 'statelist';

    protected $_nicename = 'State';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        $this->_nicename = __( 'State', Ninja_Forms::TEXTDOMAIN );
    }

    public function template()
    {
        // This section intentionally left blank.
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
