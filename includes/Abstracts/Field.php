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
     * Constructor
     */
    public function __construct()
    {

    }

    /*
    * PUBLIC METHODS
    */

    function register()
    {

    }

    public function process()
    {
        // This section intentionally left blank.
    }

    public function validate( $value )
    {
        if ( isset( $this->_attr['required'] ) AND TRUE == $this->_attr['required'] AND ! $value ) return FALSE;
    }

    public abstract function template();


}
