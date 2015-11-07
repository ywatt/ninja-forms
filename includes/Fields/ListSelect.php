<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_SelectList
 */
class NF_Fields_ListSelect extends NF_Abstracts_List
{
    protected $_name = 'listselect';

    protected $_nicename = 'Select';

    protected $_section = 'common';

    protected $_templates = array( 'listselect', 'list', 'input' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Select', 'ninja-forms' );
    }
}
