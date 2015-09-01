<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Address
 */
class NF_Fields_Address extends NF_Fields_Textbox
{
    protected $_name = 'address';

    protected $_nicename = 'Address';

    protected $_group = 'user_info';

    public function __construct()
    {
        $this->_nicename = __( 'Address', Ninja_Forms::TEXTDOMAIN );
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
