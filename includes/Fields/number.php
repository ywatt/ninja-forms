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

    public function __construct()
    {
        parent::__construct();

        $this->_settings = array_merge( $this->_settings, $this->load_settings( array( 'placeholder', 'number' ) ) );

        unset(
            $this->_settings['mask'],
            $this->_settings['input_limit_set']
        );

        $this->_nicename = __( 'Number', 'ninja-forms' );
    }

    public function get_parent_type()
    {
        return parent::get_type();
    }
}
