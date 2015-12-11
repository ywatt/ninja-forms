<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Total
 */
class NF_Fields_Total extends NF_Abstracts_Input
{
    protected $_name = 'total';

    protected $_section = 'pricing';

    protected $_aliases = array();

    protected $_type = 'textbox';

    protected $_templates = 'total';

    protected $_test_value = 'Lorem ipsum';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos' )
        );

        $this->_nicename = __( 'Total', 'ninja-forms' );
    }
}
