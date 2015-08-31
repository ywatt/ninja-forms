<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ModelFactory
 */
abstract class NF_Abstracts_Action
{
    /**
    * @var string
    */
    protected $name  = '';

    /**
     * @var array
     */
    protected $tags = array();

    /**
     * @var string
     */
    protected $timing = 'normal';

    /**
     * @var int
     */
    protected $priority = '10';

    public function __construct()
    {

    }

    /**
     * Constructor
     */
    public function register()
    {

    }

    /*
     * PUBLIC METHODS
     */
    public abstract function process();
}
