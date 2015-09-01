<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_FirstName
 */
class NF_Fields_LastName extends NF_Fields_Textbox
{
    protected $_name = 'lastname';

    protected $_nicename = 'Last Name';

    protected $_group = 'user_info';

    public function __construct()
    {
        $this->_nicename = __( 'Last Name', Ninja_Forms::TEXTDOMAIN );
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
