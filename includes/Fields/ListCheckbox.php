<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_CheckboxList
 */
class NF_Fields_ListCheckbox extends NF_Abstracts_List
{
    protected $_name = 'listcheckbox';

    protected $_nicename = 'Checkbox List';

    protected $_section = '';

    protected $_templates = 'listcheckbox';

    protected $_old_classname = 'list-checkbox';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Checkbox List', 'ninja-forms' );
    }

    public function admin_form_element( $id, $value )
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

//        $field = Ninja_Forms()->form()->get_field( $id );
//
//        $options = '<option>--</option>';
//        foreach( $field->get_setting( 'options' ) as $option ){
//            $selected = ( $value == $option[ 'value' ] ) ? "selected" : '';
//            $options .= "<option value='{$option[ 'value' ]}' $selected>{$option[ 'label' ]}</option>";
//        }
//
//        return "<select class='widefat' name='fields[$id]' id=''>$options</select>";
    }
}
