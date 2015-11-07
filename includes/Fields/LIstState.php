<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_ListState
 */
class NF_Fields_ListState extends NF_Abstracts_List
{
    protected $_name = 'liststate';

    protected $_nicename = 'State';

    protected $_section = 'userinfo';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'State', 'ninja-forms' );
    }
}
