<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Hidden
 */
class NF_Fields_Hidden extends NF_Abstracts_Input
{
    protected $_name = 'hidden';

    protected $_nicename = 'Hidden';

    protected $_section = '';

    protected $_type = 'hidden';

    protected $_templates = array( 'hidden', 'textbox', 'input' );

    public function __construct()
    {
        parent::__construct();

        // $this->_settings = $this->load_settings(
        //     array( 'label', 'default' )
        // );

        unset(
            $this->_settings['label_pos'],
            $this->_settings['required'],
            $this->_settings['mask'],
            $this->_settings['input_limit_set'],
            $this->_settings['classes'],
            $this->_settings['default']
        );

        $this->_nicename = __( 'Hidden', 'ninja-forms' );
    }
}
