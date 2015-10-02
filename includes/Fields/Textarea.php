<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Textarea
 */
class NF_Fields_Textarea extends NF_Abstracts_Field
{
    const TEMPLATE = 'textarea';

    protected $_name = 'textarea';

    protected $_nicename = 'Textarea';

    protected $_group = 'standard_fields';


    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Textarea', Ninja_Forms::TEXTDOMAIN );

        $settings = Ninja_Forms::config( 'InputFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }
}
