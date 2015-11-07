<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Button
 */
class NF_Fields_Button extends NF_Abstracts_Field
{
    protected $_name = 'button';

    protected $_nicename = 'Button';

    protected $_section = '';

    protected $_type = 'button';

    protected $_templates = array( 'button', 'input' );

    public function __construct()
    {
        parent::__construct();

        $this->_settings[ 'label' ][ 'width' ] = 'full';

        unset( $this->_settings[ 'label_pos' ] );
        unset( $this->_settings[ 'placeholder' ] );
        unset( $this->_settings[ 'required' ] );

        $this->_nicename = __( 'Button', 'ninja-forms' );
    }
}
