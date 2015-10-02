<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_CheckboxList
 */
class NF_Fields_ListCheckbox extends NF_Abstracts_List
{
    protected $_name = 'checkboxlist';

    protected $_nicename = 'Checkbox List';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Checkbox List', Ninja_Forms::TEXTDOMAIN );
    }
}
