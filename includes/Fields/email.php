<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Email
 */
class NF_Fields_Email extends NF_Abstracts_Input
{
    protected $_name = 'email';

    protected $_nicename = 'email';

    protected $_group = 'standard_fields';

    protected $_type = 'email';

    public function __construct()
    {
        $this->_nicename = __( 'email', Ninja_Forms::TEXTDOMAIN );
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
