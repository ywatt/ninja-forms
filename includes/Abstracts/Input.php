<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Input
 */
abstract class NF_Abstracts_Input extends NF_Abstracts_Field
{
    protected $_name = 'input';

    protected $_section = 'common';

    protected $_type = 'text';

    protected $_templates = array( 'input' );

    public function __construct()
    {
        parent::__construct();

        $settings = Ninja_Forms::config( 'FieldInputSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    public function get_parent_type()
    {
        return parent::get_type();
    }
}
