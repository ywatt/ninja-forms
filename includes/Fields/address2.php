<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Address2
 */
class NF_Fields_Address2 extends NF_Fields_Textbox
{
    protected $_name = 'address2';

    protected $_nicename = 'Address 2';

    protected $_group = 'user_info';

    public function __construct()
    {
        $this->_nicename = __( 'Address 2', Ninja_Forms::TEXTDOMAIN );
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
