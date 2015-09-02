<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Input
 */
abstract class NF_Abstracts_Input extends NF_Abstracts_Field
{
    protected $_name = 'input';

    protected $_group = 'standard_fields';

    protected $_type = 'text';

    public function __construct()
    {
        parent::__construct();

        $settings = Ninja_Forms::config( 'InputFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
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
