<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Textbox
 */
final class NF_Field_Textbox extends NF_Abstracts_Field
{
    protected $_name = 'textbox';

    protected $_group = 'standard_fields';

<<<<<<< HEAD
    public function __construct()
    {

=======
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
>>>>>>> f6c89349c7eb34b21b8485858b481eb503e621f7
    }

}
