<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_SelectList
 */
class NF_Fields_SelectList extends NF_Abstracts_List
{
    protected $_name = 'selectlist';

    protected $_nicename = 'Select';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        $this->_nicename = __( 'Select', Ninja_Forms::TEXTDOMAIN );
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
