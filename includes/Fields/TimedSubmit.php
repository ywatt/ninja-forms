<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Button
 */
class NF_Fields_TimedSubmit extends NF_Fields_Button
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

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
