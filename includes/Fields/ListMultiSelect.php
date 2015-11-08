<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_MultiselectList
 */
class NF_Fields_ListMultiselect extends NF_Abstracts_List
{
    protected $_name = 'listmultiselect';

    protected $_nicename = 'Mulit-Select';

    protected $_section = '';

    protected $_templates = array( 'listmultiselect', 'list', 'input' );

    protected $_old_classname = 'list-multiselect';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Multi-Select', 'ninja-forms' );
    }
}
