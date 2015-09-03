<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_CheckboxList
 */
class NF_Fields_CheckboxList extends NF_Abstracts_List
{
    protected $_name = 'checkboxlist';

    protected $_nicename = 'Checkbox List';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        parent::__construct();
        
        $this->_nicename = __( 'Checkbox List', Ninja_Forms::TEXTDOMAIN );
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
