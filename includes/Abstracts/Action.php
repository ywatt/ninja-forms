<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Action
 */
abstract class NF_Abstracts_Action
{
    /**
    * @var string
    */
    protected $_name  = '';

    /**
     * @var array
     */
    protected $_tags = array();

    /**
     * @var string
     */
    protected $_timing = 'normal';

    /**
     * @var int
     */
    protected $_priority = '10';

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /*
     * PUBLIC METHODS
     */

    /**
     * Save
     */
    public abstract function save();

    /**
     * Process
     */
    public abstract function process( $action_id, $form_id, $data );
}
