<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_MultiselectList
 */
class NF_Fields_MultiselectList extends NF_Abstracts_List
{
    protected $_name = 'multiselectlist';

    protected $_nicename = 'Mulit-Select';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        $this->_nicename = __( 'Multi-Select', Ninja_Forms::TEXTDOMAIN );
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
