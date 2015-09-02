<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Date
 */
class NF_Fields_Date extends NF_Abstracts_Input
{
    protected $_name = 'date';

    protected $_nicename = 'Date';

    protected $_group = 'standard_fields';

    protected $_type = 'date';

    public function __construct()
    {
        $this->_nicename = __( 'Date', Ninja_Forms::TEXTDOMAIN );
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
