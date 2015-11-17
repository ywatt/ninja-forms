<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Checkbox
 */
class NF_Fields_Checkbox extends NF_Abstracts_Input
{
    protected $_name = 'checkbox';

    protected $_nicename = 'Checkbox';

    protected $_section = 'common';

    protected $_type = 'checkbox';

    protected $_templates = 'checkbox';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Checkbox', 'ninja-forms' );

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'checkbox_default_value', 'required', 'classes' )
        );

        $this->_settings[ 'label_pos' ][ 'value' ] = 'right';

    }
}
