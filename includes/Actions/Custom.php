<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_Custom
 */
final class NF_Actions_Custom extends NF_Abstracts_Action
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

    public function save()
    {

    }

    public function process( $action_id, $form_id, $data )
    {
        $type = Ninja_Forms()->form( $form_id )->get_action( $action_id )->get_setting( 'hook' );
        $tag  = Ninja_Forms()->form( $form_id )->get_action( $action_id )->get_setting( 'tag' );

        ob_start(); // Use the Output Buffer to suppress output

        switch( $type ){
            case 'action':
                do_action( $tag, $data );
                break;
            case 'filter':
                $data = apply_filters( $tag, $data );
                break;
        }

        ob_end_clean();

        return $data;
    }
}
