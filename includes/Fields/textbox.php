<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Field_Textbox extends NF_Abstracts_Field
{
    protected $_name = 'textbox';

    protected $_group = 'standard_fields';

    protected $_type = 'text';

    public function template()
    {
        // Placeholder output
        ?>
        <input type="<?php echo $this->type; ?>">
        <?php
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
