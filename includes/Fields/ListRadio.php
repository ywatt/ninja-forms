<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_RadioList
 */
class NF_Fields_ListRadio extends NF_Abstracts_List
{
    const TEMPLATE = 'listradio';

    protected $_name = 'listradio';

    protected $_section = 'common';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Radio List', Ninja_Forms::TEXTDOMAIN );
    }
}
