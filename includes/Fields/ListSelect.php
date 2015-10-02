<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_SelectList
 */
class NF_Fields_ListSelect extends NF_Abstracts_List
{
    protected $_name = 'selectlist';

    protected $_nicename = 'Select';

    protected $_group = 'standard_fields';

    protected $_template ='';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Select', Ninja_Forms::TEXTDOMAIN );
    }
}
