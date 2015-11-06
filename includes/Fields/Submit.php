<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Button
 */
class NF_Fields_Submit extends NF_Fields_Button
{
    const TEMPLATE = 'submit';

    protected $_name = 'submit';

    protected $_nicename = 'Submit Button';

    protected $_section = 'common';

    protected $_type = 'submit';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Button', Ninja_Forms::TEXTDOMAIN );

        $settings = Ninja_Forms::config( 'SubmitFieldSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );

        add_filter( 'nf_sub_hidden_field_types', array( $this, 'hide_field_type' ) );
    }

    function hide_field_type( $field_types )
    {
        $field_types[] = $this->_name;

        return $field_types;
    }

}
