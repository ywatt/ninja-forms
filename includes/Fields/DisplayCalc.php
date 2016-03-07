<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_DisplayCalc
 */
class NF_Fields_DisplayCalc extends NF_Abstracts_Field
{
    protected $_name = 'display_calc';

    protected $_section = 'misc';

    protected $_aliases = array();

    protected $_type = 'display_calc';

    protected $_templates = 'display_calc';

    protected $_settings = array( 'calc_var' );

    protected $_settings_exclude = array( 'required' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Display Variable', 'ninja-forms' );
    }
}
