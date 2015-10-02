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
        parent::__construct();

        $this->_nicename = __( 'Date', Ninja_Forms::TEXTDOMAIN );

        $settings = Ninja_Forms::config( 'DateFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }
}
