<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_FirstName
 */
class NF_Fields_FirstName extends NF_Abstracts_UserInfo
{
    protected $_name = 'firstname';

    protected $_nicename = 'First Name';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'First Name', Ninja_Forms::TEXTDOMAIN );

        $settings = Ninja_Forms::config( 'UserInfoFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
