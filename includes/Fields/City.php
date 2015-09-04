<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_City
 */
class NF_Fields_City extends NF_Fields_Textbox
{
    protected $_name = 'city';

    protected $_nicename = 'City';

    protected $_group = 'user_info';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'City', Ninja_Forms::TEXTDOMAIN );
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
