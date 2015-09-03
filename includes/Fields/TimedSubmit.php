<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Button
 */
class NF_Fields_TimedSubmit extends NF_Field_Button
{
    protected $_name = 'timedsubmit';

    protected $_nicename = 'Timed Submit Button';

    protected $_group = 'standard_fields';

    protected $_type = 'submit';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Timed Button', Ninja_Forms::TEXTDOMAIN );
    }

    public function template()
    {
        // Placeholder output
        ?>
        <button type="<?php echo $this->_type; ?>"></button>">
        <?php
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
