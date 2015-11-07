<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Date
 */
class NF_Fields_Date extends NF_Abstracts_Input
{
    const TEMPLATE = 'textbox';

    protected $_name = 'date';

    protected $_nicename = 'Date';

    protected $_section = '';

    protected $_type = 'textbox';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Date', 'ninja-forms' );

        $settings = Ninja_Forms::config( 'DateFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }
}
