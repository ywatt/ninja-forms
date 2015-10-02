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
    protected $_group = '';

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
     const TEMPLATE = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_nicename = __( $this->_nicename, Ninja_Forms::TEXTDOMAIN );

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

}
