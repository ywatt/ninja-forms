<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_FirstName
 */
class NF_Fields_FirstName extends NF_Fields_Textbox
{
    protected $_name = 'firstname';

    protected $_nicename = 'First Name';

    protected $_group = 'user_info';

    public function __construct()
    {
        $this->_nicename = __( 'First Name', Ninja_Forms::TEXTDOMAIN );
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
