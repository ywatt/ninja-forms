<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_List
 */
abstract class NF_Abstracts_List extends NF_Abstracts_Field
{
    protected $_name = '';

    protected $_section = 'common';

    protected $_template = '';

    protected $_type = 'list';

    public function __construct()
    {
        parent::__construct();

        $settings = Ninja_Forms::config( 'FieldListSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );

        unset( $this->_settings[ 'placeholder' ] );
    }

    public function get_parent_type()
    {
        return parent::get_type();
    }
}
