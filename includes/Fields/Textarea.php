<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_Textarea
 */
class NF_Fields_Textarea extends NF_Abstracts_Field
{
    protected $_name = 'textarea';

    protected $_section = 'common';

    protected $_type = 'textarea';

    protected $_templates = 'textarea';


    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Textarea', 'ninja-forms' );

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'required', 'textarea_placeholder', 'textarea_default_value' )
        );
    }

    public function admin_form_element( $id, $value )
    {
        return "<textarea class='widefat' name='fields[$id]'>$value</textarea>";
    }
}
