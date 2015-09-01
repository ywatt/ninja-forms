<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Button
 */
class NF_Field_Button extends NF_Abstracts_Field
{
    protected $_name = 'button';

    protected $_nicename = 'button';

    protected $_group = 'standard_fields';

    protected $_type = '';

    public function __construct()
    {
        $this->_nicename = __( 'button', Ninja_Forms::TEXTDOMAIN );
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
