<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Number
 */
class NF_Fields_Number extends NF_Abstracts_Input
{
    protected $_name = 'number';

    protected $_section = 'misc';

    protected $_type = 'number';

    protected $_templates = 'number';

    protected $_test_value = 0;

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings( array( 'label', 'label_pos', 'required', 'placeholder', 'number', 'default', 'classes' ) );

        $this->_nicename = __( 'Number', 'ninja-forms' );
    }

    public function get_parent_type()
    {
        return parent::get_type();
    }
}
