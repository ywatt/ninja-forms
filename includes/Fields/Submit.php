<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Button
 */
class NF_Fields_Submit extends NF_Fields_Button
{
    protected $_name = 'submit';

    protected $_nicename = 'Submit Button';

    protected $_group = 'standard_fields';

    protected $_type = 'submit';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Button', Ninja_Forms::TEXTDOMAIN );

        $settings = Ninja_Forms::config( 'SubmitFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
