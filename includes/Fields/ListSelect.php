<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_SelectList
 */
class NF_Fields_ListSelect extends NF_Abstracts_List
{
    const TEMPLATE = 'list';

    protected $_name = 'listselect';

    protected $_nicename = 'Select';

    protected $_section = 'common';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Select', 'ninja-forms' );
    }
}
