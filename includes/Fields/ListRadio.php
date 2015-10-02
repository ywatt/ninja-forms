<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_RadioList
 */
class NF_Fields_ListRadio extends NF_Abstracts_List
{
    const TEMPLATE = 'listradio';

    protected $_name = 'radiolist';

    protected $_nicename = 'Radio List';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Radio List', Ninja_Forms::TEXTDOMAIN );
    }
}
