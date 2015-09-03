<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Password
 */
class NF_Fields_Password extends NF_Abstracts_Input
{
    protected $_name = 'password';

    protected $_nicename = 'Password';

    protected $_group = 'standard_fields';

    protected $_type = 'password';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Password', Ninja_Forms::TEXTDOMAIN );

        $settings = Ninja_Forms::config( 'PasswordFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    public function template()
    {
        // Placeholder output
        ?>
        <input type="<?php echo $this->_type; ?>">
        <?php
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
