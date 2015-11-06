<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_ListState
 */
class NF_Fields_ListState extends NF_Abstracts_List
{
    const TEMPLATE = 'state';

    protected $_name = 'liststate';

    protected $_nicename = 'State';

    protected $_section = 'common';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'State', Ninja_Forms::TEXTDOMAIN );
    }
}
