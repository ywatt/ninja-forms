<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Textbox
 */
class NF_Fields_Hidden extends NF_Abstracts_Input
{
    protected $_name = 'textbox';

    protected $_group = 'standard_fields';

    protected $_type = 'hidden';

    public function __construct()
    {
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
