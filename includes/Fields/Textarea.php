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

    protected $_test_value = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Textarea', 'ninja-forms' );

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'required', 'placeholder', 'textarea_default_value', 'input_limit_set', 'rte_enable', 'rte_media', 'rte_mobile' )
        );

        $this->_settings[ 'placeholder' ][ 'type' ] = 'textarea';
    }

    public function admin_form_element( $id, $value )
    {
        return "<textarea class='widefat' name='fields[$id]'>$value</textarea>";
    }
}
