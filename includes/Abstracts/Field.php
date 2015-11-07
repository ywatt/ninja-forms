<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Field
 */
abstract class NF_Abstracts_Field
{
    /**
    * @var string
    */
    protected $_name  = '';

    /**
     * @var string
     */
    protected $_nicename = '';

    /**
    * @var string
    */
    protected $_section = '';

    /**
     * @var array
     */
    protected $_aliases = array();

    /**
    * @var array
    */
    protected $_settings = array();

    /**
    * @var string
    */
    protected $_test_value = '';

    /**
     * @var string
     */
    protected $_attr = '';

    /**
     * @var string
     */
    protected $_type = '';

    /**
     * @var string
     */
     const TEMPLATE = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_nicename = __( $this->_nicename, 'ninja-forms' );

        $this->_settings = Ninja_Forms::config( 'FieldSettings' );
    }

    /*
    * PUBLIC METHODS
    */

    /**
     * Validate
     *
     * @param $field
     * @param $data
     * @return array $errors
     */
    public function validate( $field, $data )
    {
        $errors = array();

        if( isset( $field['required'] ) && $field['required'] && ! trim( $field['value'] ) ){
            $errors[] = 'Field is required.';
        }

        return $errors;
    }

    public function admin_form_element( $id, $value )
    {
        return "<input class='widefat' name='fields[$id]' value='$value' />";
    }

    public function get_name()
    {
        return $this->_name;
    }

    public function get_nicename()
    {
        return $this->_nicename;
    }

    public function get_section()
    {
        return $this->_section;
    }

    public function get_aliases()
    {
        return $this->_aliases;
    }

    public function get_type()
    {
        return $this->_type;
    }

    public function get_parent_type()
    {
        return ( get_parent_class() ) ? parent::_type : '';
    }

    public function get_settings()
    {
        return $this->_settings;
    }

}
