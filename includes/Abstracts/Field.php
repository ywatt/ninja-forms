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
     * @var array
     */
    protected $_templates = array();

    /**
     * @var array
     */
    protected $_old_classname = '';

    //-----------------------------------------------------
    // Public Methods
    //-----------------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
        // Translate the nicename property.
        $this->_nicename = __( $this->_nicename, 'ninja-forms' );

        // Loads a settings array from the FieldSettings configuration file.
        $this->_settings = Ninja_Forms::config( 'FieldSettings' );
    }

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

        // Required check.
        if( isset( $field['required'] ) && $field['required'] && ! trim( $field['value'] ) ){
            $errors[] = 'Field is required.';
        }

        return $errors;
    }

    /**
     * Admin Form Element
     *
     * Returns the output for editing fields in a submission.
     *
     * @param $id
     * @param $value
     * @return string
     */
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
        // If a type is not set, return 'textbox'
        return ( get_parent_class() ) ? parent::_type : 'textbox';
    }

    public function get_settings()
    {
        return $this->_settings;
    }

    public function get_templates()
    {
        return $this->_templates;
    }

    public function get_old_classname()
    {
        return $this->_old_classname;
    }

}
