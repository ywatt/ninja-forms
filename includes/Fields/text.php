<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Textbox
 */
class NF_Fields_Text extends NF_Abstracts_Input
{
    protected $_name = 'text';

    protected $_group = 'standard_fields';

    protected $_type = 'text';

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
