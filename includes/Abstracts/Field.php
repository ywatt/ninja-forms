<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Field
 */
abstract class NF_Abstracts_Field
{
    /**
<<<<<<< HEAD
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
=======
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
>>>>>>> f6c89349c7eb34b21b8485858b481eb503e621f7
    public function __construct()
    {

    }

    /*
<<<<<<< HEAD
    * PUBLIC METHODS
    */
=======
     * PUBLIC METHODS
     */
>>>>>>> f6c89349c7eb34b21b8485858b481eb503e621f7
    public function register()
    {

    }

<<<<<<< HEAD
    public abstract function template();

    public abstract function validate();

    public abstract function process();
=======
    public function process()
    {
        // This section intentionally left blank.
    }

    public function validate( $value )
    {
        if (isset($this->_attr['required']) AND !$value) return FALSE;
    }

    public abstract function template();
>>>>>>> f6c89349c7eb34b21b8485858b481eb503e621f7

}
