<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_StateList
 */
class NF_Fields_StateList extends NF_Abstracts_List
{
    protected $_name = 'statelist';

    protected $_nicename = 'State';

    protected $_group = 'standard_fields';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'State', Ninja_Forms::TEXTDOMAIN );
    }
}
