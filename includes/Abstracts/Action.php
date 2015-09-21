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

    public function get_timing()
    {
        $timing = array( 'early' => '1', 'normal' => '0', 'late' => '-1' );

        return $timing[ $this->_timing ];
    }

    public function get_priority()
    {
        return $this->_priority;
    }

    public static function sort_actions( $a, $b )
    {
        $a->timing   = Ninja_Forms()->actions[ $a->get_setting( 'type' ) ]->get_timing();
        $a->priority = Ninja_Forms()->actions[ $a->get_setting( 'type' ) ]->get_priority();

        $b->timing   = Ninja_Forms()->actions[ $b->get_setting( 'type' ) ]->get_timing();
        $b->priority = Ninja_Forms()->actions[ $b->get_setting( 'type' ) ]->get_priority();

        // Compare Priority if Timing is the same
        if( $a->timing == $b->timing)
            return $a->priority > $b->priority ? 1 : -1;

        // Compare Timing
        return $a->timing < $b->timing ? 1 : -1;
    }
}
