<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Textbox
 */
class NF_Fields_Textbox extends NF_Abstracts_Input
{
    protected $_name = 'textbox';

    protected $_section = 'common';

    protected $_aliases = array( 'input' );

    protected $_type = 'textbox';

    protected $_templates = array( 'textbox', 'input' );

    public function __construct()
    {
        parent::__construct();

        $settings = Ninja_Forms::config( 'FieldTextboxSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );

        $this->_nicename = __( 'Textbox', 'ninja-forms' );
    }
}
