<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Textarea
 */
class NF_Field_Textarea extends NF_Abstracts_Field
{
    protected $_name = 'textarea';

    protected $_nicename = 'textarea';

    protected $_group = 'standard_fields';


    public function __construct()
    {
        $this->_nicename = __( 'textarea', Ninja_Forms::TEXTDOMAIN );
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
